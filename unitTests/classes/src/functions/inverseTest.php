<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class inverseTest extends BaseTestAbstract
{
    protected static $functionName = 'inverse';

    /**
     * @dataProvider dataProvider
     */
    public function testInverse($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::inverse($matrix);

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
    public function testInverseFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = inverse($matrix);

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
    public function testInverseInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->inverse();

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
            // phpcs:disable Generic.Files.LineLength
            [
                [[-2, 1], [1.5, -0.5]],
                [[1, 2], [3, 4]],
            ],
            [
                [[-3 / 14, 5 / 14], [2 / 7, -1 / 7]],
                [[2, 5], [4, 3]],
            ],
            [
                [[-3 / 7, 4 / 7], [2 / 7, -3 / 14]],
                [[3, 8], [4, 6]],
            ],
            [
                [[53 / 360, -13 / 90, 23 / 360], [-11 / 180, 1 / 45, 19 / 180], [-7 / 360, 17 / 90, -37 / 360]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]]
            ],
            [
                [[2, 9, -5], [0, -2, 1], [-1, -3, 2]],
                [[1, 3, 1], [1, 1, 2], [2, 3, 4]],
            ],
            [
                [[-15 / 46, 9 / 46, 17 / 46], [-4 / 23, 7 / 23, 3 / 23], [25 / 46, -15 / 46, -13 / 46]],
                [[2, 3, 4], [-1, 5, 1], [5, 0, 3]],
            ],
            [
                [[8 / 265, 18 / 265, 43 / 265], [-9 / 265, 46 / 265, 51 / 265], [-14 / 265, -63 / 530, -9 / 265]],
                [[9, -9, -8], [-6, 4, -6], [7, 0, 4]],
            ],
            [
                [[-2.5426997245179033, -2.6336088154269937, -1], [-3.239669421487598, -4.330578512396688, -2], [-1, -2, -1]],
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                [[2.782151520890266, 2.892261631000376, 1.11111111111111], [3.7300363426489636, 4.851157463770084, 2.22222222222222], [1.2481851220589992, 2.25919613307001, 1.11111111111111]],
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                [[-53 / 330, 2 / 15, -1 / 6, 23 / 165], [-34 / 165, -11 / 30, 1 / 3, 31 / 330], [17 / 66, 1 / 3, -1 / 6, -8 / 33], [1 / 5, -1 / 10, 0, 1 / 10]],
                [[1, 2, 3, 4], [12, 13, 14, 5], [11, 16, 15, 6], [10, 9, 8, 7]],
            ],
            [
                [[30 / 217, -41 / 434, -39 / 434, 76 / 217], [37 / 217, 29 / 434, 17 / 434, -22 / 217], [-39 / 217, 75 / 434, 29 / 434, -12 / 217], [-12 / 217, -27 / 434, 59 / 434, 13 / 217]],
                [[1, 4, -1, 0], [2, 3, 5, -2], [0, 3, 1, 6], [3, 0, 2, 1]],
            ],
            // phpcs:enable
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testInverseInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Inverse can only be calculated for a square matrix');

        $matrix = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $result = $matrix->inverse();
    }

    public function testInverseWithZeroDeterminant()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Inverse can only be calculated for a matrix with a non-zero determinant');

        $matrix = new Matrix([[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]]);
        $result = $matrix->inverse();
    }
}
