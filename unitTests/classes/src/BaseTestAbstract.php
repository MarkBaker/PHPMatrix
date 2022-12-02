<?php

namespace MatrixTest;

use Matrix\Matrix;
use PHPUnit\Framework\TestCase;

abstract class BaseTestAbstract extends TestCase
{
    protected const PRECISION = 1.0e-12;

    protected function assertIsMatrixObject($object)
    {
        self::assertInstanceOf(Matrix::class, $object);
    }

    protected function assertOriginalMatrixIsUnchanged(array $grid, Matrix $matrix, $message = '')
    {
        self::assertEquals($grid, $matrix->toArray(), $message);
        self::assertEquals(count($grid), $matrix->rows, $message);
        self::assertEquals(count($grid[0]), $matrix->columns, $message);
    }

    protected function assertMatrixValues(Matrix $matrix, $rows, $columns, array $grid)
    {
        self::assertEquals($rows, $matrix->rows, 'Row mismatch');
        self::assertEquals($columns, $matrix->columns, 'Column mismatch');

        $matrixGrid = $matrix->toArray();
        foreach ($grid as $row => $vector) {
            foreach ($vector as $column => $expectedValue) {
                self::assertEqualsWithDelta(
                    (float) $expectedValue,
                    (float) $matrixGrid[$row][$column],
                    self::PRECISION,
                    "Invalid result at row {$row} and column {$column}"
                );
            }
        }
    }
}
