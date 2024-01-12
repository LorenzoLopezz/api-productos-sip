<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Producto extends Model implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    protected $fillable = [
        'codigo',
        'producto',
        'precio_unitario',
        'descuento',
        'existencia',
        'activo',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}


