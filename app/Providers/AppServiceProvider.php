<?php

namespace App\Providers;

use App\Models\Permiso;
use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(Schema::hasTable('permisos')){
            $this->definirGatesPorPermisos();
        }
    }

    private function definirGatesPorPermisos(){
        $permisos = Permiso::all();

        //Define un Gate para cada permiso
        foreach ($permisos as $permiso) {
            $nombre = $this->darFormatoValidoParaGateANombreDePermiso($permiso->nombre);
            Gate::define($nombre, function ($user) use ($nombre) {
                return $user->tienePermiso($nombre) || $user->esSuperAdministrador();
            });
        }
    }

    private function darFormatoValidoParaGateANombreDePermiso($nombre) {
        $nombre = iconv('UTF-8', 'ASCII//TRANSLIT', $nombre);
        $nombre = strtolower(trim($nombre));
        return implode('_', explode(' ', $nombre));
    }
}
