<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Dokumen extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'dokumen';

    protected $fillable = [
        'id',
        'nomor_surat',
        'tim_teknis',
        'tanggal_awal_dinas',
        'tanggal_akhir_dinas',
        'sisa_hari',
        'status',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function tracking(): HasMany
    {
        return $this->hasMany(TrackingDokumen::class, 'id_dokumen', 'id');
    }

}
