<?php

namespace App\Models;

use App\Helpers\SubdomainHelper;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubdomainRequest extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * Daftar Tipe Pengajuan Subdomain
     */
    public static function getRequestTypes()
    {
        return [
            'baru'         => __('Baru'),
            'perpanjangan' => __('Perpanjangan'),
            'ubah'         => __('Ubah'),
            'hapus'        => __('Hapus'),
        ];
    }

    protected $table = 'subdomain_requests';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'pse_id',
        'user_id',
        'request_type',
        'subdomain_name',
        'is_primary',
        'status',
    ];

    /**
     * Mutator: Normalisasi subdomain_name
     * User bebas input dengan/tanpa suffix, sistem selalu simpan dengan suffix
     */
    public function setSubdomainNameAttribute($value)
    {
        $this->attributes['subdomain_name'] = SubdomainHelper::normalize($value);
    }

    /**
     * Accessor: Get URL dari subdomain
     */
    public function getSubdomainUrlAttribute()
    {
        return SubdomainHelper::generateUrl($this->subdomain_name);
    }

    //relasi ke tabel pses
    public function pse()
    {
        return $this->belongsTo(Pse::class);
    }

    //relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    //relasi ke tabel verification_histories
    public function verificationHistories()
    {
        return $this->morphMany(VerificationHistory::class, 'verifiable');
    }

    // Accessor untuk mendapatkan tanggal disetujui
    public function getApprovedAtAttribute()
    {
        $approvalHistory = $this->verificationHistories()
                                ->where('status', 'approved')
                                ->latest()
                                ->first();

        return $approvalHistory ? $approvalHistory->created_at : $this->updated_at;
    }

    //relasi ke tabel documents
    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    /**
     * Helper: Check subdomain availability
     * Returns ['available' => bool, 'message' => ?string]
     */
    public static function checkAvailability($subdomainName, $requestType, $excludeId = null)
    {
        $normalizedName = SubdomainHelper::normalize($subdomainName);

        // Logic for 'baru'
        if ($requestType === 'baru') {
            // Check approved
            $approved = self::where('subdomain_name', $normalizedName)
                ->where('request_type', 'baru')
                ->where('status', 'approved')
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists();

            if ($approved) {
                return ['available' => false, 'message' => __('messages.subdomain.store_error_exists', ['name' => $subdomainName])];
            }

            // Check pending
            $pending = self::where('subdomain_name', $normalizedName)
                ->where('request_type', 'baru')
                ->whereIn('status', ['pending_1', 'pending_2'])
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists();

            if ($pending) {
                return ['available' => false, 'message' => __('messages.subdomain.store_error_pending', ['name' => $subdomainName])];
            }
        }

        // Logic for others (ubah, perpanjangan, hapus)
        if (in_array($requestType, ['ubah', 'perpanjangan', 'hapus'])) {
            // Check approved (must exist)
            $approved = self::where('subdomain_name', $normalizedName)
                ->where('request_type', 'baru')
                ->where('status', 'approved')
                ->exists();

            if (!$approved) {
                return ['available' => false, 'message' => __('messages.subdomain.store_error_not_approved', ['name' => $subdomainName])];
            }

            // Check pending
            $pending = self::where('subdomain_name', $normalizedName)
                ->whereIn('status', ['pending_1', 'pending_2'])
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists();

            if ($pending) {
                return ['available' => false, 'message' => __('messages.subdomain.store_error_pending', ['name' => $subdomainName])];
            }
        }

        return ['available' => true, 'message' => null];
    }
}
