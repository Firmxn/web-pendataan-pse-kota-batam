<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role_name',
    ];

    // relasi ke tabel users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //lowercase role name for easier comparison
    // mutator
    public function setRoleNameAttribute($value)
    {
        $this->attributes['role_name'] = strtolower($value);
    }

    //accessor
    public function getRoleNameAttribute($value)
    {
        return strtolower($value);
    }
}
