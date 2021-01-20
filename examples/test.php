<?php

use Matrix\Matrix;
use Matrix\Decomposition\QR;

include __DIR__ . '/../vendor/autoload.php';

$grid = [
    [1, 2, 3, 4, 5, 6, 7],
    [9, 8, 7, 6, 5, 4, 3],
    [-2, -1, 0, 1, 2, 3, 4],
];

$matrix = new Matrix($grid);

$decomposition = new QR($matrix);
$Q = $decomposition->getQ();
$R = $decomposition->getR();

echo 'Q', PHP_EOL;
var_export($Q->toArray());
echo PHP_EOL;

echo 'R', PHP_EOL;
var_export($R->toArray());
echo PHP_EOL;

$resolve = $Q->multiply($R);

echo 'Resolve', PHP_EOL;
var_export($resolve->toArray());
echo PHP_EOL;


$q1 = [
    [-0.24253562503633308, 0.9701425001453319],
    [-0.9701425001453319, -0.24253562503633308],
];
$r1 = [
    [-4.123105625617661, -5.335783750799326, -6.5484618759809905],
    [0.0, 0.7276068751089992, 1.4552137502179976],
];
$r = (new Matrix($q1))->multiply(new Matrix($r1));

echo 'Resolve', PHP_EOL;
var_export($r->toArray());
echo PHP_EOL;
