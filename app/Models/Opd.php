<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'opds';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'email',
    ];

    // relasi ke tabel users
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
