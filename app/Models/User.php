<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasUuid;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasUuid;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'opd_id',
        'name',
        'email',
        'phone',
        'nip',
        'position',
        'status',
        'work_unit',
        'work_unit_phone',
    ];

    public function getAuthPassword()
    {
        return '';
    }

    // relasi ke tabel opd
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    // relasi ke tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // relasi ke tabel pse
    public function pses()
    {
        return $this->hasMany(Pse::class);
    }

    // relasi ke tabel subdomain_requests
    public function subdomainRequests()
    {
        return $this->hasMany(SubdomainRequest::class);
    }

    // relasi ke tabel hosting_requests
    public function hostingRequests()
    {
        return $this->hasMany(HostingRequest::class);
    }

    // relasi ke tabel document
    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    // relasi ke tabel verification_histories
    public function verificationHistories()
    {
        return $this->hasMany(VerificationHistory::class);
    }

    // lowercase email field
    // mutan
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // accessor
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    // capitalize name field
    // mutator
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    // accessor
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    // uppercase nip field
    // mutator
    public function setNipAttribute($value)
    {
        $this->attributes['nip'] = strtoupper($value);
    }

    // accessor
    public function getNipAttribute($value)
    {
        return strtoupper($value);
    }

    // app/Models/User.php

    // Mutator untuk phone
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $this->normalizePhone($value);
    }

    // Mutator untuk work_unit_phone
    public function setWorkUnitPhoneAttribute($value)
    {
        $this->attributes['work_unit_phone'] = $this->normalizePhone($value);
    }

    // Helper method private
    private function normalizePhone($value)
    {
        if (empty($value)) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $value);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    // Accessor untuk format display
    public function getFormattedPhoneAttribute()
    {
        return format_phone($this->phone);
    }

    public function getFormattedWorkUnitPhoneAttribute()
    {
        return format_phone($this->work_unit_phone);
    }

}
