<?php

namespace MatrixTest\Functions;

use Matrix\Exception;
use Matrix\Functions;
use Matrix\Matrix;
use MatrixTest\BaseTestAbstract;
use function Matrix\adjoint;
use function Matrix\antidiagonal;
use function Matrix\cofactors;
use function Matrix\determinant;
use function Matrix\diagonal;
use function Matrix\identity;
use function Matrix\inverse;
use function Matrix\minors;
use function Matrix\trace;
use function Matrix\transpose;

class FunctionsCallTest extends BaseTestAbstract
{
    public function testAdjoint()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::adjoint($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::adjoint($matrix1)->toArray());
        $this->assertEquals([[4, -2], [-3, 1]], Functions::adjoint($matrix2Grid)->toArray());
        $this->assertEquals([[4, -2], [-3, 1]], Functions::adjoint($matrix2)->toArray());
        $this->assertEquals([[18, -36, 6], [16, 20, -12], [-23, 20, 27]], Functions::adjoint($matrix3Grid)->toArray());
        $this->assertEquals([[18, -36, 6], [16, 20, -12], [-23, 20, 27]], Functions::adjoint($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::adjoint(1);
    }

    public function testAntidiagonal()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::antidiagonal($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::antidiagonal($matrix1)->toArray());
        $this->assertEquals([[0, 2], [3, 0]], Functions::antidiagonal($matrix2Grid)->toArray());
        $this->assertEquals([[0, 2], [3, 0]], Functions::antidiagonal($matrix2)->toArray());
        $this->assertEquals([[0, 0, 2], [0, 4, 0], [5, 0, 0]], Functions::antidiagonal($matrix3Grid)->toArray());
        $this->assertEquals([[0, 0, 2], [0, 4, 0], [5, 0, 0]], Functions::antidiagonal($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::antidiagonal(1);
    }

    public function testCofactors()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::cofactors($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::cofactors($matrix1)->toArray());
        $this->assertEquals([[4, -3], [-2, 1]], Functions::cofactors($matrix2Grid)->toArray());
        $this->assertEquals([[4, -3], [-2, 1]], Functions::cofactors($matrix2)->toArray());
        $this->assertEquals([[18, 16, -23], [-36, 20, 20], [6, -12, 27]], Functions::cofactors($matrix3Grid)->toArray());
        $this->assertEquals([[18, 16, -23], [-36, 20, 20], [6, -12, 27]], Functions::cofactors($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::cofactors(1);
    }

    public function testDeterminant()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals(1024.0, Functions::determinant($matrix1Grid));
        $this->assertEquals(1024.0, Functions::determinant($matrix1));
        $this->assertEquals(-2.0, Functions::determinant($matrix2Grid));
        $this->assertEquals(-2.0, Functions::determinant($matrix2));
        $this->assertEquals(156.0, Functions::determinant($matrix3Grid));
        $this->assertEquals(156.0, Functions::determinant($matrix3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::determinant(1);
    }

    public function testDiagonal()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::diagonal($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::diagonal($matrix1)->toArray());
        $this->assertEquals([[1, 0], [0, 4]], Functions::diagonal($matrix2Grid)->toArray());
        $this->assertEquals([[1, 0], [0, 4]], Functions::diagonal($matrix2)->toArray());
        $this->assertEquals([[5, 0, 0], [0, 4, 0], [0, 0, 6]], Functions::diagonal($matrix3Grid)->toArray());
        $this->assertEquals([[5, 0, 0], [0, 4, 0], [0, 0, 6]], Functions::diagonal($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::diagonal(1);
    }

    public function testIdentity()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1]], Functions::identity($matrix1Grid)->toArray());
        $this->assertEquals([[1]], Functions::identity($matrix1)->toArray());
        $this->assertEquals([[1, null], [null, 1]], Functions::identity($matrix2Grid)->toArray());
        $this->assertEquals([[1, null], [null, 1]], Functions::identity($matrix2)->toArray());
        $this->assertEquals([[1, null, null], [null, 1, null], [null, null, 1]], Functions::identity($matrix3Grid)->toArray());
        $this->assertEquals([[1, null, null], [null, 1, null], [null, null, 1]], Functions::identity($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::identity(1);
    }

    public function testInverse()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[0.0009765625]], Functions::inverse($matrix1Grid)->toArray());
        $this->assertEquals([[0.0009765625]], Functions::inverse($matrix1)->toArray());
        $this->assertEquals([[-2.0, 1.0], [1.5, -0.5]], Functions::inverse($matrix2Grid)->toArray());
        $this->assertEquals([[-2.0, 1.0], [1.5, -0.5]], Functions::inverse($matrix2)->toArray());
        $this->assertEquals(
            [
                [0.11538461538461538, -0.23076923076923075, 0.038461538461538464],
                [0.10256410256410256, 0.1282051282051282, -0.07692307692307693],
                [-0.14743589743589744, 0.1282051282051282, 0.17307692307692307]
            ],
            Functions::inverse($matrix3Grid)->toArray()
        );
        $this->assertEquals(
            [
                [0.11538461538461538, -0.23076923076923075, 0.038461538461538464],
                [0.10256410256410256, 0.1282051282051282, -0.07692307692307693],
                [-0.14743589743589744, 0.1282051282051282, 0.17307692307692307]
            ],
            Functions::inverse($matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::inverse(1);
    }

    public function testMinors()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::minors($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::minors($matrix1)->toArray());
        $this->assertEquals([[4, 3], [2, 1]], Functions::minors($matrix2Grid)->toArray());
        $this->assertEquals([[4, 3], [2, 1]], Functions::minors($matrix2)->toArray());
        $this->assertEquals([[18, -16, -23], [36, 20, -20], [6, 12, 27]], Functions::minors($matrix3Grid)->toArray());
        $this->assertEquals([[18, -16, -23], [36, 20, -20], [6, 12, 27]], Functions::minors($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::minors(1);
    }

    public function testTrace()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals(1024, Functions::trace($matrix1Grid));
        $this->assertEquals(1024, Functions::trace($matrix1));
        $this->assertEquals(5, Functions::trace($matrix2Grid));
        $this->assertEquals(5, Functions::trace($matrix2));
        $this->assertEquals(15, Functions::trace($matrix3Grid));
        $this->assertEquals(15, Functions::trace($matrix3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::trace(1);
    }

    public function testTranspose()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], Functions::transpose($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], Functions::transpose($matrix1)->toArray());
        $this->assertEquals([[1, 3], [2, 4]], Functions::transpose($matrix2Grid)->toArray());
        $this->assertEquals([[1, 3], [2, 4]], Functions::transpose($matrix2)->toArray());
        $this->assertEquals([[5, -1, 5], [7, 4, 3], [2, 2, 6]], Functions::transpose($matrix3Grid)->toArray());
        $this->assertEquals([[5, -1, 5], [7, 4, 3], [2, 2, 6]], Functions::transpose($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        Functions::transpose(1);
    }
}
