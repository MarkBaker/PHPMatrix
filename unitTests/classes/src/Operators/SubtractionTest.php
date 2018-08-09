<?php

namespace Matrix\Operators;

use \Matrix\Matrix;

class SubtractionTest extends \PHPUnit_Framework_TestCase
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

        $result = (new Subtraction($matrix))
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals($matrix, $result);
    }

    public function testSubtractInvalid()
    {
        $matrix = $this->getTestMatrix1();

        $subtractor = new Subtraction($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Invalid argument for subtraction');
        $result = $subtractor->execute("ElePHPant")
            ->result();
    }

    public function testSubtractScalar()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute(5)
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[-4, -3, -2], [-1, 0, 1], [2, 3, 4]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testSubtractMatrix()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute($this->getTestMatrix2())
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[-1, -5, -3], [-5, 0, 5], [3, 5, 1]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testSubtractMismatchedMatrices()
    {
        $matrix = $this->getTestMatrix1();

        $subtractor = new Subtraction($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $subtractor->execute($this->getTestMatrix3())
            ->result();
    }
}
