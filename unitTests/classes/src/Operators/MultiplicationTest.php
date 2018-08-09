<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class MultiplicationTest extends BaseTestAbstract
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

        $result = (new Multiplication($matrix))
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($original), count($original[0]), $original);
    }

    public function testMultiplyInvalid()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $subtractor = new Multiplication($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid argument for multiplication');

        $result = $subtractor->execute("ElePHPant")
            ->result();
    }

    public function testMultiplyScalar()
    {
        $expected = [[5, 10, 15], [20, 25, 30], [35, 40, 45]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute(5)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function testMultiplyMatrix()
    {
        $expected = [[32, 26, 32], [77, 71, 77], [122, 116, 122]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute($this->getTestMatrix2())
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testMultiplyMismatchedMatrices()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $multiplier = new Multiplication($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $multiplier->execute($this->getTestMatrix3())
            ->result();
    }
}
