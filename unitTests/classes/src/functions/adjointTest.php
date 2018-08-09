<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class adjointTest extends BaseTestAbstract
{
    protected static $functionName = 'adjoint';

    /**
     * @dataProvider dataProvider
     */
    public function testAdjoint($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::adjoint($matrix);

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
    public function testAdjointFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = adjoint($matrix);

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
    public function testAdjointInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->adjoint();

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
                [[4, -2], [-3, 1]],
                [[1, 2], [3, 4]],
            ],
            [
                [[3, -5], [-4, 2]],
                [[2, 5], [4, 3]],
            ],
            [
                [[6, -8], [-4, 3]],
                [[3, 8], [4, 6]],
            ],
            [
                [[-53, 52, -23], [22, -8, -38], [7, -68, 37]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]]
            ],
            [
                [[-2, -9, 5], [0, 2, -1], [1, 3, -2]],
                [[1, 3, 1], [1, 1, 2], [2, 3, 4]],
            ],
            [
                [[15, -9, -17], [8, -14, -6], [-25, 15, 13]],
                [[2, 3, 4], [-1, 5, 1], [5, 0, 3]],
            ],
            [
                [[16, 36, 86], [-18, 92, 102], [-28, -63, -18]],
                [[9, -9, -8], [-6, 4, -6], [7, 0, 4]],
            ],
            [
                [[-9.23, -9.56, -3.63], [-11.76, -15.72, -7.26], [-3.63, -7.26, -3.63]],
                [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]],
            ],
            [
                [[-9.2553, -9.6216, -3.6963], [-12.4086, -16.1382, -7.3926], [-4.1523, -7.5156, -3.6963]],
                [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]],
            ],
            [
                [[-106, 88, -110, 92], [-136, -242, 220, 62], [170, 220, -110, -160], [132, -66, 0, 66]],
                [[1, 2, 3, 4], [12, 13, 14, 5], [11, 16, 15, 6], [10, 9, 8, 7]],
            ],
            [
                [[-60, 41, 39, -152], [-74, -29, -17, 44], [78, -75, -29, 24], [24, 27, -59, -26]],
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

    public function testAdjointInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Adjoint can only be calculated for a square matrix');

        $matrix = new Matrix([[1, 2, 3], [4, 5, 6]]);
        $result = $matrix->adjoint();
    }
}
