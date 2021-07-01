<?php

namespace MatrixTest\Operations;

use Matrix\Exception;
use Matrix\Matrix;
use Matrix\Operations;
use MatrixTest\BaseTestAbstract;
use function Matrix\add;
use function Matrix\directsum;
use function Matrix\divideby;
use function Matrix\divideinto;
use function Matrix\multiply;
use function Matrix\subtract;

class OperationsCallTest extends BaseTestAbstract
{
    public function testAdd()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[2048]], Operations::add($matrix1Grid, $matrix1)->toArray());
        $this->assertEquals([[2, 4], [6, 8]], Operations::add($matrix2, $matrix2Grid)->toArray());
        $this->assertEquals([[10, 14, 4], [-2, 8, 4], [10, 6, 12]], Operations::add($matrix3Grid, $matrix3)->toArray());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Addition arguments must be Matrix or array');
        Operations::add(1, 2);
    }

    public function testAddInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Addition operation requires at least 2 arguments');
        Operations::add(1);
    }

    public function testDirectSum()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1024, 0], [0, 1024]], Operations::directsum($matrix1, $matrix1Grid)->toArray());
        $this->assertEquals(
            [
                [1, 2, 0, 0], [3, 4, 0, 0], [0, 0, 1, 2], [0, 0, 3, 4]
            ],
            Operations::directsum($matrix2, $matrix2Grid)->toArray()
        );
        $this->assertEquals(
            [
                [5, 7, 2, 0, 0, 0],
                [-1, 4, 2, 0, 0, 0],
                [5, 3, 6, 0, 0, 0],
                [0, 0, 0, 5, 7, 2],
                [0, 0, 0, -1, 4, 2],
                [0, 0, 0, 5, 3, 6]
            ],
            Operations::directsum($matrix3Grid, $matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('DirectSum arguments must be Matrix or array');
        Operations::directsum(1, 2);
    }

    public function testDirectSumInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('DirectSum operation requires at least 2 arguments');
        Operations::directsum(1);
    }

    public function testDivideBy()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1.0]], Operations::divideby($matrix1Grid, $matrix1)->toArray());
        $this->assertEquals([[1.0, 0.0], [0.0, 1.0]], Operations::divideby($matrix2, $matrix2Grid)->toArray());
        $this->assertEquals(
            [
                [0.9999999999999998, 0.0, -1.1102230246251565E-16],
                [0.0, 0.9999999999999999, 0.0],
                [0.0, 0.0, 0.9999999999999999]
            ],
            Operations::divideby($matrix3Grid, $matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Division arguments must be Matrix or array');
        Operations::divideby(1, 2);
    }

    public function testDivideByInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Division operation requires at least 2 arguments');
        Operations::divideby(1);
    }

    public function testDivideInto()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1.0]], Operations::divideinto($matrix1Grid, $matrix1)->toArray());
        $this->assertEquals([[1.0, 0.0], [0.0, 1.0]], Operations::divideinto($matrix2, $matrix2Grid)->toArray());
        $this->assertEquals(
            [
                [0.9999999999999998, 0.0, -1.1102230246251565E-16],
                [0.0, 0.9999999999999999, 0.0],
                [0.0, 0.0, 0.9999999999999999]
            ],
            Operations::divideinto($matrix3Grid, $matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Division arguments must be Matrix or array');
        Operations::divideinto(1, 2);
    }

    public function testDivideIntoInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Division operation requires at least 2 arguments');
        Operations::divideinto(1);
    }

    public function testMultiply()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[1048576]], Operations::multiply($matrix1Grid, $matrix1)->toArray());
        $this->assertEquals([[7, 10], [15, 22]], Operations::multiply($matrix2, $matrix2Grid)->toArray());
        $this->assertEquals(
            [
                [28, 69, 36],
                [1, 15, 18],
                [52, 65, 52]
            ],
            Operations::multiply($matrix3Grid, $matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Multiplication arguments must be Matrix or array');
        Operations::multiply(1, 2);
    }

    public function testMultiplyInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Multiplication operation requires at least 2 arguments');
        Operations::multiply(1);
    }

    public function testSubtract()
    {
        $matrix1Grid = [[1024]];
        $matrix1 = new Matrix($matrix1Grid);
        $matrix2Grid = [[1, 2], [3, 4]];
        $matrix2 = new Matrix($matrix2Grid);
        $matrix3Grid = [[5, 7, 2], [-1, 4, 2], [5, 3, 6]];
        $matrix3 = new Matrix($matrix3Grid);
        $this->assertEquals([[0]], Operations::subtract($matrix1Grid, $matrix1)->toArray());
        $this->assertEquals([[0, 0], [0, 0]], Operations::subtract($matrix2, $matrix2Grid)->toArray());
        $this->assertEquals(
            [[0.0, 0.0, 0.0], [0.0, 0.0, 0.0], [0.0, 0.0, 0.0]],
            Operations::subtract($matrix3Grid, $matrix3)->toArray()
        );
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Subtraction arguments must be Matrix or array');
        Operations::subtract(1, 2);
    }

    public function testSubtractInvalidArgsCount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Subtraction operation requires at least 2 arguments');
        Operations::subtract(1);
    }
}
