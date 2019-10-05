<?php

namespace Matrix\Decomposition;

use Matrix\Matrix;

class Decomposition
{
    const LU = 'LU';
    const QR = 'QR';

    public static function decomposition($type, Matrix $matrix)
    {
        switch ($type) {
            case self::LU:
                return new LU($matrix);
            case self::QR:
                return new QR($matrix);
            default:
                throw new \Exception('Invalid Decomposition');
        }
    }
}
