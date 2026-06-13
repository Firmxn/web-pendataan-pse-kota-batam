<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingRequest extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'hosting_requests';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'pse_id',
        'user_id',
        'request_type',
        'hosting_type',
        'cpu_cores',
        'ram_capacity',
        'storage_capacity',
        'bandwidth_capacity',
        'notes',
        'status',
    ];

    /**
     * Tipe Pengajuan (Point 7 TODO.md)
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

    /**
     * Tipe Hosting
     */
    public static function getHostingTypes()
    {
        return [
            'shared'    => __('Shared Hosting'),
            'vps'       => __('VPS'),
            'dedicated' => __('Dedicated Server'),
            'cloud'     => __('Cloud Server'),
        ];
    }

    /**
     * Kapasitas CPU Cores
     */
    public static function getCpuCores()
    {
        return [1, 2, 4, 8, 16, 32];
    }

    /**
     * Kapasitas RAM (GB)
     */
    public static function getRamCapacities()
    {
        return [1, 2, 4, 8, 16, 32, 64];
    }

    /**
     * Kapasitas Storage (GB)
     */
    public static function getStorageCapacities()
    {
        return [10, 20, 50, 100, 200, 500, 1000];
    }

    /**
     * Kapasitas Bandwidth (GB)
     */
    public static function getBandwidthCapacities()
    {
        return [100, 500, 1000, 5000];
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
}
