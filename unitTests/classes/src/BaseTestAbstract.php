<?php

namespace MatrixTest;

use Matrix\Matrix;
use PHPUnit\Framework\TestCase;

abstract class BaseTestAbstract extends TestCase
{
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
        self::assertEquals($rows, $matrix->rows);
        self::assertEquals($columns, $matrix->columns);
        self::assertEquals($grid, $matrix->toArray());
    }
}
