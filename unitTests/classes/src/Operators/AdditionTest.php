<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class AdditionTest extends BaseTestAbstract
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

        $result = (new Addition($matrix))
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($original), count($original[0]), $original);
    }

    public function testAddInvalid()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid argument for addition');

        $result = $adder->execute("ElePHPant")
            ->result();
    }

    public function testAddScalar()
    {
        $expected = [[6, 7, 8], [9, 10, 11], [12, 13, 14]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $result = $adder->execute(5)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function testAddMatrix()
    {
        $expected = [[3, 9, 9], [13, 10, 7], [11, 11, 17]];
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $result = $adder->execute($this->getTestMatrix2())
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, 3, 3, $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testAddMismatchedMatrices()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $adder->execute($this->getTestMatrix3())
            ->result();
    }
}
