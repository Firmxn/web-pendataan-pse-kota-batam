<?php

namespace App\Models;

use App\Helpers\SubdomainHelper;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pse extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * Daftar Sektor PSE baku
     * Digunakan untuk Dropdown di Form dan Validasi di Controller
     */
    public static function getSectors()
    {
        return [
            'administrasi'  => __('Administrasi Pemerintahan'),
            'pendidikan'    => __('Pendidikan'),
            'kesehatan'     => __('Kesehatan'),
            'sosial'        => __('Sosial'),
            'infrastruktur' => __('Pekerjaan Umum & Tata Ruang'),
            'perhubungan'   => __('Perhubungan'),
            'pangan'        => __('Sektor Pangan & Pertanian'),
            'pariwisata'    => __('Pariwisata & Kebudayaan'),
            'perdagangan'   => __('Perdagangan & Perindustrian'),
            'lingkungan'    => __('Lingkungan Hidup'),
            'lainnya'       => __('Dan Lain-lain'),
        ];
    }

    /**
     * Daftar Kategori Risiko baku
     */
    public static function getRiskCategories()
    {
        return [
            'rendah' => __('Rendah'),
            'sedang' => __('Sedang'),
            'tinggi' => __('Tinggi'),
        ];
    }

    /**
     * Daftar Klasifikasi Data baku
     */
    public static function getDataClassifications()
    {
        return [
            'publik'         => __('Publik'),
            'internal'       => __('Internal'),
            'rahasia'        => __('Rahasia'),
            'sangat rahasia' => __('Sangat Rahasia'),
        ];
    }

    protected $table = 'pses';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'user_id',
        'opd_id',
        'system_name',
        'sector',
        'pic_name',
        'pic_phone',
        'pic_email',
        'description',
        'risk_category',
        'data_classification',
        'private_data_info',
        'storage_location',
        'status',
        'registration_number',
    ];

    /**
     * Accessor: Label Sektor (human-readable)
     */
    public function getSectorLabelAttribute()
    {
        $sectors = self::getSectors();
        return $sectors[$this->sector] ?? $this->sector;
    }

    /**
     * Daftar Lokasi Penyimpanan baku
     */
    public static function getStorageLocations()
    {
        return [
            'aplikasi'   => __('Aplikasi'),
            'colocation' => __('Colocation'),
            'eksternal'  => __('Eksternal'),
        ];
    }

    /**
     * Accessor: Label Lokasi Penyimpanan
     */
    public function getStorageLocationLabelAttribute()
    {
        $locations = self::getStorageLocations();
        return $locations[$this->storage_location] ?? $this->storage_location;
    }

    /**
     * Accessor: Get URL dari subdomain utama (Primary)
     * Untuk kompatibilitas dengan kode yang memanggil $pse->url
     */
    public function getUrlAttribute()
    {
        return $this->primarySubdomain?->subdomain_url ?? null;
    }

    //relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    //relasi ke tabel opd
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    //relasi ke tabel subdomain_requests
    public function subdomainRequests()
    {
        return $this->hasMany(SubdomainRequest::class);
    }

    /**
     * Relasi ke subdomain utama (Primary)
     */
    public function primarySubdomain()
    {
        return $this->hasOne(SubdomainRequest::class)->where('is_primary', true);
    }

    //relasi ke tabel hosting_requests
    public function hostingRequests()
    {
        return $this->hasMany(HostingRequest::class);
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
}
