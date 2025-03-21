<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado',
    ];

    protected $attributes = [
        'estado' => 'alta',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->fecha_creacion = Carbon::now(); 
            $user->fecha_modificacion = Carbon::now();  
        });

        static::updating(function ($role) {
            $role->fecha_modificacion = Carbon::now();
        });
    }
}
