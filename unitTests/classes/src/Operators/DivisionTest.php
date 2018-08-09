<?php

namespace Matrix\Operators;

use \Matrix\Matrix;

class DivisionTest extends \PHPUnit_Framework_TestCase
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

        $result = (new Division($matrix))
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals($matrix, $result);
    }

    public function testDivideInvalid()
    {
        $matrix = $this->getTestMatrix1();

        $multiplier = new Division($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Invalid argument for division');
        $result = $multiplier->execute("ElePHPant")
            ->result();
    }

    public function testDivideScalar()
    {
        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $multiplier = new Division($matrix);

        $result = $multiplier->execute(5)
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals([[0.2, 0.4, 0.6], [0.8, 1.0, 1.2], [1.4, 1.6, 1.8]], $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testDivideMatrix()
    {
        $expected = [[13 / 60, -1 / 30, 13 / 60], [5 / 12, 1 / 6, 5 / 12], [37 / 60, 11 / 30, 37 / 60]];

        $matrix = $this->getTestMatrix1();
        $original = $matrix->toArray();

        $multiplier = new Division($matrix);

        $result = $multiplier->execute($this->getTestMatrix2())
            ->result();

        // Test that the request returns a Matrix object as a result
        $this->assertTrue(is_object($result));
        $this->assertTrue(is_a($result, 'Matrix\\Matrix'));
        $this->assertEquals($expected, $result->toArray());
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function testDivideMismatchedMatrices()
    {
        $matrix = $this->getTestMatrix1();

        $multiplier = new Division($matrix);

        $this->expectException('Matrix\\Exception');
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $multiplier->execute($this->getTestMatrix3())
            ->result();
    }
}
