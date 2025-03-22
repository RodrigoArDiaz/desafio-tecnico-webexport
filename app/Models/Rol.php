<?php

namespace App\Models;

use App\Enums\EstadoRol;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'rol_usuario', 'rol_id', 'usuario_id');
    }

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'rol_id', 'permiso_id');
    }

    public function getEstadosValidos(){
        return EstadoRol::cases();
    }
}
