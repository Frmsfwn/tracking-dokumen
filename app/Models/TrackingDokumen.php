<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'id_admin',
        'status_dokumen',
        'opsi',
        'catatan',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_admin');
    }

}
