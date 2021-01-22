<?php

use Matrix\Matrix;
use Matrix\Decomposition\LU;

include __DIR__ . '/../vendor/autoload.php';

$grid = [
    [1, 0, 1, 0],
    [2, 0, 0, 2],
    [0, -1, 1, 0],
    [0, -2, 0, -2],
];

$targetGrid = [
    [2, 1],
    [3, 0],
    [4, 5],
    [7, 8],
];

$matrix = new Matrix($grid);
$target = new Matrix($targetGrid);

$decomposition = new LU($matrix);

$X = $decomposition->solve($target);

echo 'X', PHP_EOL;
var_export($X->toArray());
echo PHP_EOL;

$resolve = $matrix->multiply($X);

echo 'Resolve', PHP_EOL;
var_export($resolve->toArray());
echo PHP_EOL;
