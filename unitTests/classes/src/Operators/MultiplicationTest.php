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

    /**
     * @dataProvider scalarMultiplicationProvider
     */
    public function testMultiplyScalar($original, $multiplicand, $expected)
    {
        $matrix = new Matrix($original);

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute($multiplicand)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function scalarMultiplicationProvider()
    {
        return [
            // phpcs:disable Generic.Files.LineLength
            [$this->getTestGrid1(), 5, [[5, 10, 15], [20, 25, 30], [35, 40, 45]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], -12.34, [[13.574, -27.148, 40.722], [-54.296, 67.87, -81.444]]],
            // phpcs:enable
        ];
    }

    /**
     * @dataProvider matrixMultiplicationProvider
     */
    public function testMultiplyMatrix($original, $multiplicand, $expected)
    {
        $matrix = new Matrix($original);

        $multiplier = new Multiplication($matrix);

        $result = $multiplier->execute($multiplicand)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function matrixMultiplicationProvider()
    {
        return [
            // phpcs:disable Generic.Files.LineLength
            [$this->getTestGrid1(), $this->getTestMatrix2()->toArray(), [[32, 26, 32], [77, 71, 77], [122, 116, 122]]],
            [[[1.1, 2.2, 3.3], [4.4, 5.5, 6.6]], [[9.9, 8.8], [7.7, 6.6], [5.5, 4.4]], [[45.98, 38.72], [122.21, 104.06]]],
            [[[1.1, 2.2], [3.3, 4.4], [5.5, 6.6]], [[9.9, 8.8, 7.7], [6.6, 5.5, 4.4]], [[25.41, 21.78, 18.15], [61.71, 53.24, 44.77], [98.01, 84.70, 71.39]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], [[9.9, -8.8], [-7.7, 6.6], [5.5, -4.4]], [[-45.98, 38.72], [122.21, -104.06]]],
            [[[1.1, -2.2], [-3.3, 4.4], [5.5, -6.6]], [[9.9, -8.8, 7.7], [-6.6, 5.5, -4.4]], [[25.41, -21.78, 18.15], [-61.71, 53.24, -44.77], [98.01, -84.70, 71.39]]],
            [[[9.9, 8.8, 7.7], [6.6, 5.5, 4.4]], [[1.1, 2.2], [3.3, 4.4], [5.5, 6.6]], [[82.28, 111.32], [49.61, 67.76]]],
            [[[9.9, 8.8], [7.7, 6.6], [5.5, 4.4]], [[1.1, 2.2, 3.3], [4.4, 5.5, 6.6]], [[49.61, 70.18, 90.75], [37.51, 53.24, 68.97], [25.41, 36.30, 47.19]]],
            [[[1, 2, 3, 4], [5, 6, 7, 8]], [[9, 8], [7, 6], [5, 4], [3, 2]], [[50, 40], [146, 120]]],
            // phpcs:enable
        ];
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
