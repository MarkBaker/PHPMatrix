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

    protected function assertOriginalMatrixIsUnchanged(array $grid, Matrix $matrixObject)
    {
        $this->assertEquals($grid, $matrixObject->toArray());
        $this->assertEquals(count($grid), $matrixObject->rows);
        $this->assertEquals(count($grid[0]), $matrixObject->columns);
    }

    protected function assertMatrixValues(Matrix $matrixObject, $rows, $columns, array $grid)
    {
        $this->assertEquals($rows, $matrixObject->rows);
        $this->assertEquals($columns, $matrixObject->columns);
        $this->assertEquals($grid, $matrixObject->toArray());
    }
}
