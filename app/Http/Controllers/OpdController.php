<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Opd::class);

        $query = Opd::query();

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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Whitelist: hanya kolom terdaftar yang diizinkan untuk sorting, mencegah SQL injection via orderBy
        $allowedSortFields = ['name', 'type', 'email', 'created_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDir);
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->orderBy('created_at', 'desc');
        }

        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        
        $opds = $query->paginate($perPage)->appends($request->all());

        return view('opd.index', compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Opd::class);
        return view('opd.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Opd::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:opds,name'],
            'type' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150', 'unique:opds,email'],
        ]);

        Opd::create($validated);

        return redirect()->route('opd.index')->with('success', __('Instansi (OPD) baru berhasil ditambahkan.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opd $opd): View
    {
        $this->authorize('update', $opd);
        return view('opd.edit', compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opd $opd): RedirectResponse
    {
        $this->authorize('update', $opd);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:opds,name,' . $opd->id],
            'type' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150', 'unique:opds,email,' . $opd->id],
        ]);

        $opd->update($validated);

        return redirect()->route('opd.index')->with('success', __('Instansi (OPD) berhasil diperbarui.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opd $opd): RedirectResponse
    {
        $this->authorize('delete', $opd);

        $opd->delete();

        return redirect()->route('opd.index')->with('success', __('Instansi (OPD) berhasil dinonaktifkan.'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id): RedirectResponse
    {
        $opd = Opd::onlyTrashed()->findOrFail($id);
        
        $this->authorize('restore', $opd);

        $opd->restore();

        return redirect()->route('opd.index')->with('success', __('Instansi (OPD) berhasil dipulihkan.'));
    }
}
