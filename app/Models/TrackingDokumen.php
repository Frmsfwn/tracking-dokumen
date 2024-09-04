<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrackingDokumen extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'tracking_dokumen';

    protected $fillable = [
        'id',
        'id_dokumen',
        'pengajuan_nota_dinas',
        'penerbitan_surat_dinas',
        'pembuatan_rampung',
        'penandatanganan_rampung',
        'penandatanganan_ppk',
        'penandatanganan_kabag_umum',
        'proses_spby',
        'proses_transfer',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

}
