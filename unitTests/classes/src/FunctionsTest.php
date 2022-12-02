<?php

namespace MatrixTest;

use Matrix\Exception;
use Matrix\Functions;
use Matrix\Matrix;

class FunctionsTest extends BaseTestAbstract
{
    /** @var Matrix $matrix1x1 */
    private $matrix1x1;
    /** @var Matrix $matrix2x2 */
    private $matrix2x2;
    /** @var Matrix $matrix3x3 */
    private $matrix3x3;
    /** @var Matrix $matrix2x4 */
    private $matrix2x4;

    public function __construct()
    {
        parent::__construct();
        $this->matrix1x1 = new Matrix([[1024]]);
        $this->matrix2x2 = new Matrix([[8, 4], [3, 5]]);
        $this->matrix3x3 = new Matrix([[1, 2, 5], [1, 3, 5], [1, 2, 1]]);
        $this->matrix2x4 = new Matrix([[1, 2], [3, 4], [5, 6], [7, 8]]);
    }

    public function testAdjoint()
    {
        $this->assertEquals(
            new Matrix([[-7, 8, -5], [4, -4, 0], [-1, 0, 1]]),
            Functions::adjoint($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Adjoint can only be calculated for a square matrix');
        Functions::adjoint($this->matrix2x4);
    }

    public function testAntidiagonal()
    {
        $this->assertEquals(
            new Matrix([[0, 0, 5], [0, 3, 0], [1, 0, 0]]),
            Functions::antidiagonal($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Anti-Diagonal can only be extracted from a square matrix');
        Functions::antidiagonal($this->matrix2x4);
    }

    public function testCofactors()
    {
        $this->assertEquals(
            new Matrix([[-7, 4, -1], [8, -4, 0], [-5, 0, 1]]),
            Functions::cofactors($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Cofactors can only be calculated for a square matrix');
        Functions::cofactors($this->matrix2x4);
    }

    public function testDeterminant()
    {
        $this->assertEquals(1024, Functions::determinant($this->matrix1x1));
        $this->assertEquals(28, Functions::determinant($this->matrix2x2));
        $this->assertEquals(-4, Functions::determinant($this->matrix3x3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Determinant can only be calculated for a square matrix');
        Functions::determinant($this->matrix2x4);
    }

    public function testDiagonal()
    {
        $this->assertEquals(
            new Matrix([[1, 0, 0], [0, 3, 0], [0, 0, 1]]),
            Functions::diagonal($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Diagonal can only be extracted from a square matrix');
        Functions::diagonal($this->matrix2x4);
    }

    public function testIdentity()
    {
        $this->assertEquals(
            new Matrix([[1, null, null], [null, 1, null], [null, null, 1]]),
            Functions::identity($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Identity can only be created for a square matrix');
        Functions::identity($this->matrix2x4);
    }

    public function testInverse()
    {
        $expectedInverted1x1 = new Matrix([
            [0.0009765625]
        ]);
        $inverted1x1 = Functions::inverse($this->matrix1x1);
        $this->assertEqualsWithDelta($expectedInverted1x1, $inverted1x1, self::PRECISION);
        $this->assertEqualsWithDelta($this->matrix1x1, Functions::inverse($inverted1x1), self::PRECISION);

        $expectedInverted2x2 = new Matrix([
            [0.17857142857142855, -0.14285714285714285],
            [-0.10714285714285714, 0.2857142857142857]
        ]);
        $inverted2x2 = Functions::inverse($this->matrix2x2);
        $this->assertEqualsWithDelta($expectedInverted2x2, $inverted2x2, self::PRECISION);
        $this->assertEqualsWithDelta($this->matrix2x2, Functions::inverse($inverted2x2), self::PRECISION);

        $expectedInverted3x3 = new Matrix([
            [1.75, -2.0, 1.25],
            [-1.0, 1.0, 0.0],
            [0.25, 0.0, -0.25]
        ]);
        $inverted3x3 = Functions::inverse($this->matrix3x3);
        $this->assertEqualsWithDelta($expectedInverted3x3, $inverted3x3, self::PRECISION);
        $this->assertEqualsWithDelta($this->matrix3x3, Functions::inverse($inverted3x3), self::PRECISION);
    }

    public function testInverseNotSquare(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Inverse can only be calculated for a square matrix');
        Functions::inverse($this->matrix2x4);
    }

    public function testInverseNotSquare2(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Inverse can only be calculated for a matrix with a non-zero determinant');
        Functions::inverse(new Matrix([0]));
    }

    public function testMinors()
    {
        $this->assertEquals(
            new Matrix([[1024]]),
            Functions::minors($this->matrix1x1)
        );
        $this->assertEquals(
            new Matrix([[-7, -4, -1], [-8, -4, 0], [-5, 0, 1]]),
            Functions::minors($this->matrix3x3)
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Minors can only be calculated for a square matrix');
        Functions::minors($this->matrix2x4);
    }

    public function testTrace()
    {
        $this->assertEquals(5, Functions::trace($this->matrix3x3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Trace can only be extracted from a square matrix');
        Functions::trace($this->matrix2x4);
    }

    public function testTranspose()
    {
        $this->assertEquals(
            new Matrix([[1, 1, 1], [2, 3, 2], [5, 5, 1]]),
            Functions::transpose($this->matrix3x3)
        );
    }
}
