<?php

namespace App\Enums;

enum MovementType: string
{
    case INCOME = 'income';
    case OUTCOME = 'outcome';
    case LOSS = 'loss';

    public function label(): string
    {
        return match($this) {
            self::INCOME => 'Ingreso de Inventario',
            self::OUTCOME => 'Salida por Venta',
            self::LOSS => 'Merma / Pérdida',
        };
    }
    public function isPositive(): bool
    {
        return $this === self::INCOME;
    }
}
