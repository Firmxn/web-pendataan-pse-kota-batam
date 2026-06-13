<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan filter.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        // Query base
        $query = User::query()
            ->select('users.*')
            ->with(['opd', 'role'])
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('opds', 'users.opd_id', '=', 'opds.id');

        // Filter: Verifikator dilarang melihat akun dengan otoritas lebih tinggi
        if (auth()->user()->role->role_name === 'verifikator_1') {
            $query->whereNotIn('roles.role_name', ['admin', 'eksekutif', 'verifikator_2']);
        } elseif (auth()->user()->role->role_name === 'verifikator_2') {
            $query->whereNotIn('roles.role_name', ['admin', 'eksekutif']);
        }

        $status = $request->input('status', 'aktif');

        if ($status === 'dihapus') {
            $query->onlyTrashed();
        } elseif ($status === 'semua') {
            $query->withTrashed();
        }

        // Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->filled('search')) {
            $search = escapeLike($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('opds.name', 'like', "%{$search}%");
            });
        }

        // Whitelist: hanya kolom terdaftar yang diizinkan untuk sorting, mencegah SQL injection via orderBy
        $allowedSortFields = ['name', 'email', 'role_name', 'name', 'created_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        if (in_array($sortBy, $allowedSortFields)) {
            if ($sortBy === 'role_name') {
                $query->orderBy('roles.role_name', $sortDir);
            } elseif ($sortBy === 'name') {
                $query->orderBy('opds.name', $sortDir);
            } else {
                $query->orderBy("users.{$sortBy}", $sortDir);
            }
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->orderBy('users.id', 'desc');
        }

        // Pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $users = $query->paginate($perPage);

        $users->appends($request->all());

        return view('user.index', compact('users'));
    }

    /**
     * Menampilkan detail profil seorang pengguna (petugas).
     * Hanya dapat diakses oleh Verifikator 1 dan Verifikator 2.
     */
    public function show($uuid): View
    {
        $user = User::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $this->authorize('view', $user);

        // Muat relasi yang dibutuhkan untuk tampilan profil
        $user->load(['opd', 'role', 'document']);

        // Jika user adalah admin, ambil data OPD untuk form edit yang ada di halaman show (opsional)
        $opds = [];
        if (auth()->user()->role->role_name === 'admin') {
            $opds = Opd::select('id', 'name')->orderBy('name')->get();
        }

        // Tentukan URL kembali secara dinamis
        $backUrl = url()->previous();

        // Hindari perulangan tak terbatas jika di-refresh atau url tidak valid
        if (!$backUrl || $backUrl === url()->current() || str_contains($backUrl, 'login')) {
            $backUrl = in_array(auth()->user()->role->role_name, ['admin', 'verifikator_1', 'verifikator_2'])
                ? route('user.index')
                : route('dashboard');
        }

        return view('user.show', compact('user', 'opds', 'backUrl'));
    }

    /**
     * Menampilkan form registrasi petugas baru.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);
        $opds = Opd::select('id', 'name')->orderBy('name')->get();
        return view('user.create', compact('opds'));
    }

    /**
     * Menyimpan data petugas baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        $this->normalizePhoneInputs($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nip' => ['required', 'digits:18'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'opd_id' => ['required', 'exists:opds,id'],
            'position' => ['required', 'string', 'max:255'],
            'work_unit' => ['required', 'string', 'max:255'],
            'work_unit_phone' => ['required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'assignment_letter' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'phone.regex' => 'Format nomor telepon pribadi harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
            'work_unit_phone.regex' => 'Format nomor telepon unit kerja harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $rolePetugas = Role::where('role_name', 'petugas')->first();

            $user = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nip' => $validated['nip'],
                'phone' => $validated['phone'],
                'opd_id' => $validated['opd_id'],
                'role_id' => $rolePetugas->id,
                'position' => $validated['position'],
                'work_unit' => $validated['work_unit'],
                'work_unit_phone' => $validated['work_unit_phone'],
                'status' => 'active',
            ]);

            // Handle Assignment Letter
            if ($request->hasFile('assignment_letter')) {
                $file = $request->file('assignment_letter');
                $uuidFileName = Str::uuid() . '.pdf';
                $descriptiveName = sprintf('%s_surat_tugas_%s.pdf', format_filename_timestamp(), Str::slug($user->name));
                $filePath = $file->storeAs('documents/assignment_letters', $uuidFileName, 'private');

                $user->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }

            Log::info('New User Registered by Admin', [
                'registered_user_id' => $user->id,
                'registered_by' => auth()->id(),
            ]);
        });

        return redirect()->route('user.index')->with('success', __('Petugas baru berhasil didaftarkan.'));
    }

    /**
     * Menampilkan form edit profil petugas (Admin Only).
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $opds = Opd::select('id', 'name')->orderBy('name')->get();
        return view('user.edit', compact('user', 'opds'));
    }

    /**
     * Memperbarui informasi profil petugas (Admin Only).
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $this->normalizePhoneInputs($request);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'nip' => ['sometimes', 'required', 'digits:18'],
            'phone' => ['sometimes', 'required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'opd_id' => ['sometimes', 'required', 'exists:opds,id'],
            'position' => ['sometimes', 'required', 'string', 'max:255'],
            'work_unit' => ['sometimes', 'required', 'string', 'max:255'],
            'work_unit_phone' => ['sometimes', 'required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'assignment_letter' => ['sometimes', 'nullable', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'phone.regex' => 'Format nomor telepon pribadi harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
            'work_unit_phone.regex' => 'Format nomor telepon unit kerja harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
        ]);

        DB::transaction(function () use ($validated, $user, $request) {
            $user->update($validated);

            // Handle New Assignment Letter if uploaded
            if ($request->hasFile('assignment_letter')) {
                if ($user->document) {
                    Storage::disk('private')->delete($user->document->file_path);
                    $user->document->delete();
                }

                $file = $request->file('assignment_letter');
                $uuidFileName = Str::uuid() . '.pdf';
                $descriptiveName = sprintf('%s_surat_tugas_%s.pdf', format_filename_timestamp(), Str::slug($user->name));
                $filePath = $file->storeAs('documents/assignment_letters', $uuidFileName, 'private');

                $user->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }

            Log::info('User Account Updated by Admin', [
                'user_id' => $user->id,
                'updated_by' => auth()->id(),
            ]);
        });

        return redirect()->route('user.show', $user->uuid)->with('success', __('Profil petugas berhasil diperbarui.'));
    }

    /**
     * Menghapus (soft delete) akun pengguna.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        // Audit Trail Action
        Log::info('User Account Deactivated (Soft Deleted)', [
            'deleted_user_id' => $user->id,
            'deleted_user_email' => $user->email,
            'action_by' => auth()->id(),
            'action_by_role' => auth()->user()->role->role_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('user.index')->with('success', __('Akun pengguna berhasil dinonaktifkan.'));
    }

    /**
     * Memulihkan (restore) akun pengguna yang sebelumnya telah di soft-delete.
     */
    public function restore($uuid)
    {
        $user = User::onlyTrashed()->where('uuid', $uuid)->firstOrFail();

        $this->authorize('restore', $user);

        $user->restore();

        // Audit Trail Action
        Log::info('User Account Restored', [
            'restored_user_id' => $user->id,
            'restored_user_email' => $user->email,
            'action_by' => auth()->id(),
            'action_by_role' => auth()->user()->role->role_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('user.index')->with('success', __('Akun pengguna berhasil dipulihkan.'));
    }

    /**
     * Menormalisasi format nomor telepon pribadi dan nomor telepon unit kerja sebelum validasi.
     */
    private function normalizePhoneInputs(Request $request): void
    {
        if ($request->has('phone')) {
            $request->merge([
                'phone' => normalize_phone($request->input('phone'))
            ]);
        }

        if ($request->has('work_unit_phone')) {
            $request->merge([
                'work_unit_phone' => normalize_phone($request->input('work_unit_phone'))
            ]);
        }
    }
}
