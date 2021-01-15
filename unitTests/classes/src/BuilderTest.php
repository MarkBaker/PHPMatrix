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
    }
}
