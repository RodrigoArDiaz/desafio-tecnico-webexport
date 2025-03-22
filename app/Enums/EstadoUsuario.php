<?php

namespace App\Enums;

enum EstadoUsuario: string {
    case ALTA = 'alta';
    case BAJA = 'baja';
    case SUSPENDIDO = 'suspendido';
}