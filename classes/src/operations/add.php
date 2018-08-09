<?php

/**
 *
 * Function code for the matrix addition operation
 *
 * @copyright  Copyright (c) 2018 Mark Baker (https://github.com/MarkBaker/PHPMatrix)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Matrix;

use Matrix\Operators\Addition;

/**
 * Adds two or more matrices
 *
 * @param     mixed[]    $matrixValues   The matrices to add
 * @return    Matrix
 * @throws    Exception
 */
function add(...$matrixValues)
{
    if (count($matrixValues) < 2) {
        throw new Exception('This operation requires at least 2 arguments');
    }

    $result = new Addition(array_shift($matrixValues));

    foreach ($matrixValues as $matrix) {
        $result->execute($matrix);
    }

    return $result->result();
}
