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

    public function testDivideScalar()
    {
        $expected = [[0.2, 0.4, 0.6], [0.8, 1.0, 1.2], [1.4, 1.6, 1.8]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $result = $divisor->execute(5)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function testDivideMatrix()
    {
        $expected = [[13 / 60, -1 / 30, 13 / 60], [5 / 12, 1 / 6, 5 / 12], [37 / 60, 11 / 30, 37 / 60]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $divisor = new Division($matrix);

        $result = $divisor->execute($this->getTestMatrix2())
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
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
}
