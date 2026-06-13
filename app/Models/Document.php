<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'documents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'file_path',
        'original_name',
    ];

    // Relasi polymorphic ke tabel yang menggunakan dokumen
    public function documentable()
    {
        return $this->morphTo()->withTrashed();
    }
}
