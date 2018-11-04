<?php

include __DIR__ . '/../classes/Bootstrap.php';

$grid = [
    [1, -3, 3],
    [3, -5, 3],
    [6, -6, 4],
];

$matrix = new Matrix\Matrix($grid);

$lambdaI = Matrix\multiply($matrix->diagonal(), -1);

var_dump($lambdaI);

$new = $matrix->subtract($lambdaI);

var_dump($new);
