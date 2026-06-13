<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationHistory extends Model
{
    use HasFactory;

    protected $table = 'verification_histories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'verifiable_id',
        'verifiable_type',
        'status',
        'notes',
    ];

    //relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    //relasi polymorphic ke tabel yang menggunakan verification history
    public function verifiable()
    {
        return $this->morphTo();
    }
}
