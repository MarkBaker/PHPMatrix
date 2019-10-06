<?php

namespace Matrix\Test\functions;

use Matrix\Exception;
use Matrix\Matrix;
use Matrix\Test\BaseTestAbstract;
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
        $this->assertEquals([[1024]], adjoint($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], adjoint($matrix1)->toArray());
        $this->assertEquals([[4, -2], [-3, 1]], adjoint($matrix2Grid)->toArray());
        $this->assertEquals([[4, -2], [-3, 1]], adjoint($matrix2)->toArray());
        $this->assertEquals([[18, -36, 6], [16, 20, -12], [-23, 20, 27]], adjoint($matrix3Grid)->toArray());
        $this->assertEquals([[18, -36, 6], [16, 20, -12], [-23, 20, 27]], adjoint($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        adjoint(1);
    }

    public function testAntidiagonal()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], antidiagonal($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], antidiagonal($matrix1)->toArray());
        $this->assertEquals([[0, 2], [3, 0]], antidiagonal($matrix2Grid)->toArray());
        $this->assertEquals([[0, 2], [3, 0]], antidiagonal($matrix2)->toArray());
        $this->assertEquals([[0, 0, 2], [0, 4, 0], [5, 0, 0]], antidiagonal($matrix3Grid)->toArray());
        $this->assertEquals([[0, 0, 2], [0, 4, 0], [5, 0, 0]], antidiagonal($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        antidiagonal(1);
    }

    public function testCofactors()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], cofactors($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], cofactors($matrix1)->toArray());
        $this->assertEquals([[4, -3], [-2, 1]], cofactors($matrix2Grid)->toArray());
        $this->assertEquals([[4, -3], [-2, 1]], cofactors($matrix2)->toArray());
        $this->assertEquals([[18, 16, -23], [-36, 20, 20], [6, -12, 27]], cofactors($matrix3Grid)->toArray());
        $this->assertEquals([[18, 16, -23], [-36, 20, 20], [6, -12, 27]], cofactors($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        cofactors(1);
    }

    public function testDeterminant()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals(1024.0, determinant($matrix1Grid));
        $this->assertEquals(1024.0, determinant($matrix1));
        $this->assertEquals(-2.0, determinant($matrix2Grid));
        $this->assertEquals(-2.0, determinant($matrix2));
        $this->assertEquals(156.0, determinant($matrix3Grid));
        $this->assertEquals(156.0, determinant($matrix3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        determinant(1);
    }

    public function testDiagonal()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], diagonal($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], diagonal($matrix1)->toArray());
        $this->assertEquals([[1, 0], [0, 4]], diagonal($matrix2Grid)->toArray());
        $this->assertEquals([[1, 0], [0, 4]], diagonal($matrix2)->toArray());
        $this->assertEquals([[5, 0, 0], [0, 4, 0], [0, 0, 6]], diagonal($matrix3Grid)->toArray());
        $this->assertEquals([[5, 0, 0], [0, 4, 0], [0, 0, 6]], diagonal($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        diagonal(1);
    }

    public function testIdentity()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1]], identity($matrix1Grid)->toArray());
        $this->assertEquals([[1]], identity($matrix1)->toArray());
        $this->assertEquals([[1, null], [null, 1]], identity($matrix2Grid)->toArray());
        $this->assertEquals([[1, null], [null, 1]], identity($matrix2)->toArray());
        $this->assertEquals([[1, null, null], [null, 1, null], [null, null, 1]], identity($matrix3Grid)->toArray());
        $this->assertEquals([[1, null, null], [null, 1, null], [null, null, 1]], identity($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        identity(1);
    }

    public function testInverse()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[0.0009765625]], inverse($matrix1Grid)->toArray());
        $this->assertEquals([[0.0009765625]], inverse($matrix1)->toArray());
        $this->assertEquals([[-2.0, 1.0], [1.5, -0.5]], inverse($matrix2Grid)->toArray());
        $this->assertEquals([[-2.0, 1.0], [1.5, -0.5]], inverse($matrix2)->toArray());
        $this->assertEquals(
            [
                [0.11538461538461538, -0.23076923076923075, 0.038461538461538464],
                [0.10256410256410256, 0.1282051282051282, -0.07692307692307693],
                [-0.14743589743589744, 0.1282051282051282, 0.17307692307692307]
            ],
            inverse($matrix3Grid)->toArray()
        );
        $this->assertEquals(
            [
                [0.11538461538461538, -0.23076923076923075, 0.038461538461538464],
                [0.10256410256410256, 0.1282051282051282, -0.07692307692307693],
                [-0.14743589743589744, 0.1282051282051282, 0.17307692307692307]
            ],
            inverse($matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        inverse(1);
    }

    public function testMinors()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], minors($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], minors($matrix1)->toArray());
        $this->assertEquals([[4, 3], [2, 1]], minors($matrix2Grid)->toArray());
        $this->assertEquals([[4, 3], [2, 1]], minors($matrix2)->toArray());
        $this->assertEquals([[18, -16, -23], [36, 20, -20], [6, 12, 27]], minors($matrix3Grid)->toArray());
        $this->assertEquals([[18, -16, -23], [36, 20, -20], [6, 12, 27]], minors($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        minors(1);
    }

    public function testTrace()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals(1024, trace($matrix1Grid));
        $this->assertEquals(1024, trace($matrix1));
        $this->assertEquals(5, trace($matrix2Grid));
        $this->assertEquals(5, trace($matrix2));
        $this->assertEquals(15, trace($matrix3Grid));
        $this->assertEquals(15, trace($matrix3));
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        trace(1);
    }

    public function testTranspose()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024]], transpose($matrix1Grid)->toArray());
        $this->assertEquals([[1024]], transpose($matrix1)->toArray());
        $this->assertEquals([[1, 3], [2, 4]], transpose($matrix2Grid)->toArray());
        $this->assertEquals([[1, 3], [2, 4]], transpose($matrix2)->toArray());
        $this->assertEquals([[5, -1, 5], [7, 4, 3], [2, 2, 6]], transpose($matrix3Grid)->toArray());
        $this->assertEquals([[5, -1, 5], [7, 4, 3], [2, 2, 6]], transpose($matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Must be Matrix or array');
        transpose(1);
    }
}
