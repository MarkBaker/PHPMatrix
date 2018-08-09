<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class SubtractionTest extends BaseTestAbstract
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

        $result = (new Subtraction($matrix))
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($original), count($original[0]), $original);
    }

    public function testSubtractInvalid()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid argument for subtraction');

        $result = $subtractor->execute("ElePHPant")
            ->result();
    }

    public function testSubtractScalar()
    {
        $expected = [[-4, -3, -2], [-1, 0, 1], [2, 3, 4]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute(5)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function testSubtractMatrix()
    {
        $expected = [[-1, -5, -3], [-5, 0, 5], [3, 5, 1]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute($this->getTestMatrix2())
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testSubtractMismatchedMatrices()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $subtractor->execute($this->getTestMatrix3())
            ->result();
    }
}
