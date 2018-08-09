<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class antidiagonalTest extends BaseTestAbstract
{
    protected static $functionName = 'antidiagonal';

    /**
     * @dataProvider dataProvider
     */
    public function testAntidiagonal($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::antidiagonal($matrix);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testAntidiagonalFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = antidiagonal($matrix);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testAntidiagonalInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->antidiagonal();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrix);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                [[-1]],
                [[-1]],
            ],
            [
                [[null, 2], [3, null]],
                [[1, 2], [3, 4]],
            ],
            [
                [[null, null, 6], [null, 5, null], [4, null, null]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]],
            ],
            [
                [[null, null, 7], [null, 4, null], [-8, null, null]],
                [[9, -6, 7], [-9, 4, 0], [-8, -6, 4]],
            ],
            [
                [[null, null, 3.4], [null, 5.6, null], [7.8, null, null]],
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                [[null, null, -3.45], [null, -5.67, null], [-7.89, null, null]],
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                [[null, null, null, 4], [null, null, 7, null], [null, 10, null, null], [13, null, null, null]],
                [[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]],
            ],
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testAntidiagonalInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Anti-Diagonal can only be extracted from a square matrix');

        $matrix = new Matrix([[1,2,3], [4,5,6]]);
        $result = $matrix->antidiagonal();
    }
}
