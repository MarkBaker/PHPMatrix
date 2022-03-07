<?php

namespace MatrixTest;

use Matrix\Matrix;
use PHPUnit\Framework\TestCase;

abstract class BaseTestAbstract extends TestCase
{
    protected const PRECISION = 1.0e-15;

    protected function assertIsMatrixObject($object)
    {
        self::assertInstanceOf(Matrix::class, $object);
    }

    protected function assertOriginalMatrixIsUnchanged(array $grid, Matrix $matrix, $message = '')
    {
        self::assertSame($grid, $matrix->toArray(), $message);
        self::assertSame(count($grid), $matrix->rows, $message);
        self::assertSame(count($grid[0]), $matrix->columns, $message);
    }

    protected function assertMatrixValues(Matrix $matrix, $rows, $columns, array $grid)
    {
        self::assertSame($rows, $matrix->rows, 'Row mismatch');
        self::assertSame($columns, $matrix->columns, 'Column mismatch');

        $matrixGrid = $matrix->toArray();
        foreach ($grid as $row => $vector) {
            foreach ($vector as $column => $expectedValue) {
                self::assertEqualsWithDelta(
                    (float) $expectedValue,
                    (float) $matrixGrid[$row][$column],
                    1.0e-12,
                    "Invalid result at row {$row} and column {$column}"
                );
            }
        }
    }
}
