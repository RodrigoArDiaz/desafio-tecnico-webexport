<?php

namespace App\Models;

use App\Enums\EstadoUsuario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $primaryKey = 'id'; 

    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'mail',
        'fecha_de_nacimiento',
        'genero',
        'contrasenia',
        'estado',
        'fecha_creacion',
        'fecha_modificacion'
    ];

    protected $hidden = [
        'contrasenia', 
    ];

    protected $casts = [
        'fecha_de_nacimiento' => 'date',
        'es_super_administrador' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    protected function contrasenia(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->fecha_creacion = Carbon::now(); 
            $user->fecha_modificacion = Carbon::now();  
        });

        static::updating(function ($user) {
            $user->fecha_modificacion = Carbon::now();  
        });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'usuario_id', 'rol_id');
    }

    public function getFechaDeNacimientoAttribute($value)
    {
        return  Carbon::parse($value)->format('Y-m-d');
    }

    public function getEstadosValidos(){
        return EstadoUsuario::cases();
    }

    public function getRolesIds() {
        return $this->roles->pluck('id')->toArray(); 
    }

    public function getAuthPassword()
    {
        return $this->contrasenia; 
    }
}
