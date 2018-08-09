<?php

namespace Matrix\Operators;

use \Matrix\Matrix;

class MultiplicationTest extends \PHPUnit_Framework_TestCase
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

        $result = (new Multiplication($matrix))
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals($matrix, $result);
    }

    public function testMultiplyInvalid()
    {
        $matrix = $this->getTestMatrix1();

        $multiplier = new Multiplication($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Invalid argument for multiplication');
        $result = $multiplier->execute("ElePHPant")
            ->result();
    }

    public function testMultiplyScalar()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute(5)
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[5, 10, 15], [20, 25, 30], [35, 40, 45]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testMultiplyMatrix()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute($this->getTestMatrix2())
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[32, 26, 32], [77, 71, 77], [122, 116, 122]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testMultiplyMismatchedMatrices()
    {
        $matrix = $this->getTestMatrix1();

        $multiplier = new Multiplication($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $multiplier->execute($this->getTestMatrix3())
            ->result();
    }
}
