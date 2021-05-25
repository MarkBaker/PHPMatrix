<?php

namespace MatrixTest;

use Matrix\Builder;
use Matrix\Matrix;

class BuilderTest extends BaseTestAbstract
{
    public function testCreateFilledMatrix()
    {
        $matrix = Builder::createFilledMatrix(7, 3);
        $this->assertIsMatrixObject($matrix);
        $this->assertEquals(
            new Matrix([[7, 7, 7], [7, 7, 7], [7, 7, 7]]),
            $matrix
        );
    }

    public function testCreateIdentityMatrix()
    {
        $matrix = Builder::createIdentityMatrix(3);
        $this->assertIsMatrixObject($matrix);
        $this->assertEquals(
            new Matrix([[1, null, null], [null, 1, null], [null, null, 1]]),
            $matrix
        );
        $arr = $matrix->toArray();
        $this->assertSame([1, null, null], $arr[0]);
        $this->assertSame([null, 1, null], $arr[1]);
        $this->assertSame([null, null, 1], $arr[2]);
    }

    public function testCreateIdentityMatrixWithZeros()
    {
        $matrix = Builder::createIdentityMatrix(3, 0);
        $this->assertIsMatrixObject($matrix);
        $this->assertEquals(
            new Matrix([[1, null, 0], [0, 1, 0], [0, 0, 1]]),
            $matrix
        );
        $arr = $matrix->toArray();
        $this->assertSame([1, 0, 0], $arr[0]);
        $this->assertSame([0, 1, 0], $arr[1]);
        $this->assertSame([0, 0, 1], $arr[2]);
    }
}
