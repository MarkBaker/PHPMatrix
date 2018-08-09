<?php

namespace Matrix;

abstract class BaseTestAbstract extends \PHPUnit\Framework\TestCase
{
    protected function assertIsMatrixObject($matrixObject)
    {
        //    Must return an object...
        $this->assertTrue(is_object($matrixObject));
        //    ... of the correct type
        $this->assertTrue(is_a($matrixObject, __NAMESPACE__ . '\Matrix'));
    }

    protected function assertOriginalMatrixIsUnchanged(array $grid, Matrix $matrixObject, $message = '')
    {
        $this->assertEquals($grid, $matrixObject->toArray(), $message);
        $this->assertEquals(count($grid), $matrixObject->rows, $message);
        $this->assertEquals(count($grid[0]), $matrixObject->columns, $message);
    }

    protected function assertMatrixValues(Matrix $matrixObject, $rows, $columns, array $grid)
    {
        $this->assertEquals($rows, $matrixObject->rows);
        $this->assertEquals($columns, $matrixObject->columns);
        $this->assertEquals($grid, $matrixObject->toArray());
    }
}
