<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class DivisionTest extends BaseTestAbstract
{
    protected function getTestGrid1()
    {
        return [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ];
    }

    protected function getTestMatrix2()
    {
        return new Matrix([
            [2, 7, 6],
            [9, 5, 1],
            [4, 3, 8],
        ]);
    }

    protected function getTestMatrix3()
    {
        return new Matrix([
            [1, 2],
            [3, 4],
        ]);
    }

    public function testGetResult()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $result = (new Division($matrix))
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($original), count($original[0]), $original);
    }

    public function testDivideInvalid()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid argument for division');
        $result = $divisor->execute("ElePHPant")
            ->result();
    }

    /**
     * @dataProvider scalarDivisionProvider
     */
    public function testDivideScalar($original, $dividend, $expected)
    {
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $result = $divisor->execute($dividend)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function scalarDivisionProvider()
    {
        return [
            // phpcs:disable Generic.Files.LineLength
            [$this->getTestGrid1(), 5, [[0.2, 0.4, 0.6], [0.8, 1.0, 1.2], [1.4, 1.6, 1.8]]],
            [$this->getTestGrid1(), -12, [[-1 / 12, -1 / 6, -1 / 4], [-1 / 3, -5 / 12, -1 / 2], [-7 / 12, -2 / 3, -3 / 4]]],
            [$this->getTestGrid1(), 0.25, [[4, 8, 12], [16, 20, 24], [28, 32, 36]]],
            // phpcs:enable
        ];
    }

    /**
     * @dataProvider matrixDivisionProvider
     */
    public function testDivideMatrix($original, $dividend, $expected)
    {
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $result = $divisor->execute($dividend)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function matrixDivisionProvider()
    {
        return [
            // phpcs:disable Generic.Files.LineLength
            [$this->getTestGrid1(), $this->getTestMatrix2()->toArray(), [[13 / 60, -1 / 30, 13 / 60], [5 / 12, 1 / 6, 5 / 12], [37 / 60, 11 / 30, 37 / 60]]],
            [[[13, 26], [39, 13]], [[7, 4], [2, 3]], [[-1, 10], [7, -5]]],
            [[[7, 4], [2, 3]], [[13, 26], [39, 13]], [[1 / 13, 2 / 13], [7 / 65, 1 / 65]]],
            // phpcs:enable
        ];
    }

    public function testDivideMismatchedMatrices()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $divisor->execute($this->getTestMatrix3())
            ->result();
    }

    public function testDivideZeroDeterminant()
    {
        $matrix = $this->getTestMatrix2();

        $divisor = new Division($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Division can only be calculated using a matrix with a non-zero determinant');
        $result = $divisor->execute(new Matrix($this->getTestGrid1()))
            ->result();
    }
}
