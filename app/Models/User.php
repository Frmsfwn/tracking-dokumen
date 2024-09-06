<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'user';

    protected $fillable = [
        'id',
        'nip',
        'nama',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function tracking(): BelongsTo
    {
        return $this->belongsTo(TrackingDokumen::class, 'id', 'id_admin');
    }

}
