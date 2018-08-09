<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class cofactorsTest extends BaseTestAbstract
{
    protected static $functionName = 'cofactors';

    /**
     * @dataProvider dataProvider
     */
    public function testCofactors($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::cofactors($matrix);

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
    public function testCofactorsFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = cofactors($matrix);

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
    public function testCofactorsInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->cofactors();

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
                [[4, -3], [-2, 1]],
                [[1, 2], [3, 4]],
            ],
            [
                [[3, -4], [-5, 2]],
                [[2, 5], [4, 3]],
            ],
            [
                [[6, -4], [-8, 3]],
                [[3, 8], [4, 6]],
            ],
            [
                [[-53, 22, 7], [52, -8, -68], [-23, -38, 37]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]]
            ],
            [
                [[-2, 0, 1], [-9, 2, 3], [5, -1, -2]],
                [[1, 3, 1], [1, 1, 2], [2, 3, 4]],
            ],
            [
                [[15, 8, -25], [-9, -14, 15], [-17, -6, 13]],
                [[2, 3, 4], [-1, 5, 1], [5, 0, 3]],
            ],
            [
                [[16, -18, -28], [36, 92, -63], [86, 102, -18]],
                [[9, -9, -8], [-6, 4, -6], [7, 0, 4]],
            ],
            [
                [[-9.23, -11.76, -3.63], [-9.56, -15.72, -7.26], [-3.63, -7.26, -3.63]],
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                [[-9.2553, -12.4086, -4.1523], [-9.6216, -16.1382, -7.5156], [-3.6963, -7.3926, -3.6963]],
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                [[-106, -136, 170, 132], [88, -242, 220, -66], [-110, 220, -110, 0], [92, 62, -160, 66]],
                [[1, 2, 3, 4], [12, 13, 14, 5], [11, 16, 15, 6], [10, 9, 8, 7]],
            ],
            [
                [[-60, -74, 78, 24], [41, -29, -75, 27], [39, -17, -29, -59], [-152, 44, 24, -26]],
                [[1, 4, -1, 0], [2, 3, 5, -2], [0, 3, 1, 6], [3, 0, 2, 1]],
            ],
            [
                [[-136, -408, 408, 136], [-408, -1224, 1224, 408], [408, 1224, -1224, -408], [136, 408, -408, -136]],
                [[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]],
            ],
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testCofactorsInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cofactors can only be calculated for a square matrix');

        $matrix = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $result = $matrix->cofactors();
    }
}
