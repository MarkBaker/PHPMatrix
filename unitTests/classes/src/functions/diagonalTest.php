<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class diagonalTest extends BaseTestAbstract
{
    protected static $functionName = 'diagonal';

    /**
     * @dataProvider dataProvider
     */
    public function testDiagonal($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::diagonal($matrix);

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
    public function testDiagonalFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = diagonal($matrix);

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
    public function testDiagonalInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->diagonal();

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
                [[1, null], [null, 4]],
                [[1, 2], [3, 4]],
            ],
            [
                [[8, null, null], [null, 5, null], [null, null, 2]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]],
            ],
            [
                [[9, null, null], [null, 4, null], [null, null, 4]],
                [[9, -6, 7], [-9, 4, 0], [-8, -6, 4]],
            ],
            [
                [[1.2, null, null], [null, 5.6, null], [null, null, 9.0]],
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                [[-1.23, null, null], [null, -5.67, null], [null, null, -9.01]],
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                [[1, null, null, null], [null, 6, null, null], [null, null, 11, null], [null, null, null, 16]],
                [[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]],
            ],
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testDiagonalInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Diagonal can only be extracted from a square matrix');

        $matrix = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $result = $matrix->diagonal();
    }
}
