<?php

/**
 *
 * Function code for the matrix division operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPMatrix)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Matrix;

/**
 * Divides two or more matrix numbers
 *
 * @param     array of string|integer|float|Matrix    $matrixValues   The numbers to divide
 * @return    Matrix
 */
function divideinto(...$matrixValues)
{
    if (count($matrixValues) < 2) {
        throw new \Exception('This function requires at least 2 arguments');
    }

    $base = array_shift($matrixValues);
    $result = clone Matrix::validateMatrixArgument($base);

    foreach ($matrixValues as $matrix) {
        $matrix = Matrix::validateMatrixArgument($matrix);

        if ($result->isMatrix() && $matrix->isMatrix() &&
            $result->getSuffix() !== $matrix->getSuffix()) {
            throw new Exception('Suffix Mismatch');
        }
        if ($result->getReal() == 0.0 && $result->getImaginary() == 0.0) {
            throw new \InvalidArgumentException('Division by zero');
        }

        $delta1 = ($matrix->getReal() * $result->getReal()) +
            ($matrix->getImaginary() * $result->getImaginary());
        $delta2 = ($matrix->getImaginary() * $result->getReal()) -
            ($matrix->getReal() * $result->getImaginary());
        $delta3 = ($result->getReal() * $result->getReal()) +
            ($result->getImaginary() * $result->getImaginary());

        $real = $delta1 / $delta3;
        $imaginary = $delta2 / $delta3;

        $result = new Matrix(
            $real,
            $imaginary,
            ($imaginary == 0.0) ? null : max($result->getSuffix(), $matrix->getSuffix())
        );
    }

    return $result;
}
