<?php

namespace Matrix\Test;

use Matrix\Functions;
use Matrix\Matrix;

class FunctionsTest extends BaseTestAbstract
{
    public function testFunctions()
    {
        $matrix = new Matrix([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        $this->assertEquals(
            new Matrix([[-3, 6, -3], [6, -12, 6], [-3, 6, -3]]),
            Functions::adjoint($matrix)
        );
        $this->assertEquals(
            new Matrix([[0, 0, 3], [0, 5, 0], [7, 0, 0]]),
            Functions::antidiagonal($matrix)
        );
        $this->assertEquals(
            new Matrix([[-3, 6, -3], [6, -12, 6], [-3, 6, -3]]),
            Functions::cofactors($matrix)
        );
        $this->assertEquals(0, Functions::determinant($matrix));
        $this->assertEquals(
            new Matrix([[1, 0, 0], [0, 5, 0], [0, 0, 9]]),
            Functions::diagonal($matrix)
        );
        $this->assertEquals(
            new Matrix([[1, null, null], [null, 1, null], [null, null, 1]]),
            Functions::identity($matrix)
        );
        $this->assertEquals(
            new Matrix([[-3, -6, -3], [-6, -12, -6], [-3, -6, -3]]),
            Functions::minors($matrix)
        );
        $this->assertEquals(15, Functions::trace($matrix));
        $this->assertEquals(
            new Matrix([[1, 4, 7], [2, 5, 8], [3, 6, 9]]),
            Functions::transpose($matrix)
        );
    }

    public function testInverse()
    {
        $matrix = new Matrix([[9, 7], [5, 1]]);
        $inverted = Functions::inverse($matrix);
        $this->assertEquals($matrix, Functions::inverse($inverted));
    }
}
