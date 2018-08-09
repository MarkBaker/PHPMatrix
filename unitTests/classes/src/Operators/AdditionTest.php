<?php

namespace Matrix\Operators;

use \Matrix\Matrix;

class AdditionTest extends \PHPUnit_Framework_TestCase
{
    protected function getTestMatrix1()
    {
        return new Matrix([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);
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
        $matrix = $this->getTestMatrix1();

        $result = (new Addition($matrix))
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals($matrix, $result);
    }

    public function testAddInvalid()
    {
        $matrix = $this->getTestMatrix1();

        $adder = new Addition($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Invalid argument for addition');
        $result = $adder->execute("ElePHPant")
            ->result();
    }

    public function testAddScalar()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $adder = new Addition($matrix);

        $result = $adder->execute(5)
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[6, 7, 8], [9, 10, 11], [12, 13, 14]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testAddMatrix()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $adder = new Addition($matrix);

        $result = $adder->execute($this->getTestMatrix2())
            ->result();

            // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[3, 9, 9], [13, 10, 7], [11, 11, 17]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testAddMismatchedMatrices()
    {
        $matrix = $this->getTestMatrix1();

        $adder = new Addition($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $adder->execute($this->getTestMatrix3())
            ->result();
    }
}