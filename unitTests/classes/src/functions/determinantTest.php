<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class determinantTest extends BaseTestAbstract
{
    protected static $functionName = 'determinant';

    /**
     * @dataProvider dataProvider
     */
    public function testDeterminant($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::determinant($matrix);

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testDeterminantFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = determinant($matrix);

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testDeterminantInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->determinant();

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                -9,
                [[-9]],
            ],
            [
                -2,
                [[1, 2], [3, 4]],
            ],
            [
                -14,
                [[3, 8], [4, 6]],
            ],
            [
                14,
                [[4, 6], [3, 8]],
            ],
            [
                -11,
                [[2, 5], [1, -3]],
            ],
            [
                -360,
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]],
            ],
            [
                530,
                [[9, -6, 7], [-9, 4, 0], [-8, -6, 4]],
            ],
            [
                -306,
                [[6, 1, 1], [4, -2, 5], [2, 8, 7]],
            ],
            [
                -44,
                [[3, 0, -1], [2, -5, 4], [-3, 1, 3]],
            ],
            [
                -19,
                [[2, -3, 1], [4, 2, -1], [-5, 3, -2]],
            ],
            [
                3.63,
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                -3.32667,
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                72,
                [[1, 2, 3, 4], [5, 6, 7, 8], [2, 6, 4, 8], [3, 1, 1, 2]],
            ],
            [
                0,
                [[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]],
            ],
            [
                -100,
                [[5, 2, 0, 0, -2], [0, 1, 4, 3, 2], [0, 0, 2, 6, 3], [0, 0, 3, 4, 1], [0, 0, 0, 0, 2]],
            ],
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testDeterminantInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Determinant can only be calculated for a square matrix');

        $matrix = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $result = $matrix->determinant();
    }
}
