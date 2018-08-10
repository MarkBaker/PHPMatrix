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

    /**
     * @dataProvider scalarSubtractionProvider
     */
    public function testSubtractScalar($original, $subtraction, $expected)
    {
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute($subtraction)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function scalarSubtractionProvider()
    {
        return [
            [$this->getTestGrid1(), 5, [[-4, -3, -2], [-1, 0, 1], [2, 3, 4]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], -3.21, [[2.11, 5.41, -0.09], [7.61, -2.29, 9.81]]],
        ];
    }

    /**
     * @dataProvider matrixSubtractionProvider
     */
    public function testSubtractMatrix($original, $subtraction, $expected)
    {
        $matrix = new Matrix($original);

        $subtractor = new Subtraction($matrix);

        $result = $subtractor->execute($subtraction)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function matrixSubtractionProvider()
    {
        return [
            [$this->getTestGrid1(), $this->getTestMatrix2(), [[-1, -5, -3], [-5, 0, 5], [3, 5, 1]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], [[7.7, -8.8, 9.9], [0.0, 1.1, -2.2]], [[-8.8, 11.0, -13.2], [4.4, -6.6, 8.8]]],
        ];
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
