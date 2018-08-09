<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class transposeTest extends BaseTestAbstract
{
    protected static $functionName = 'transpose';

    /**
     * @dataProvider dataProvider
     */
    public function testTranspose($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::transpose($matrix);

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
    public function testTransposeFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = transpose($matrix);

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
    public function testTransposeInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->transpose();

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
            [[[1, 3], [2, 4]],                                                  [[1, 2], [3, 4]]],
            [[[8, 3, 4], [1, 5, 9], [6, 7, 2]],                                 [[8, 1, 6], [3, 5, 7], [4, 9, 2]]],
            [[[9, -9, -8], [-6, 4, -6], [7, 0, 4]],                             [[9, -6, 7], [-9, 4, 0], [-8, -6, 4]]],
            [[[1.2, -4.5, 7.8], [-2.3, 5.6, -8.9], [3.4, -6.7, 9.0]],           [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]]],
            [[[-1.23, 4.56, -7.89], [2.34, -5.67, 8.90], [-3.45, 6.78, -9.01]], [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]]]
            // phpcs:enable
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }
}
