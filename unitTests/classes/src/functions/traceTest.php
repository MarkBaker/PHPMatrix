<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class traceTest extends BaseTestAbstract
{
    protected static $functionName = 'trace';

    /**
     * @dataProvider dataProvider
     */
    public function testTrace($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::trace($matrix);

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testTraceFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = trace($matrix);

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testTraceInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->trace();

        $this->assertEquals($expected, $result);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    public function dataProvider()
    {
        return [
            [  -1,    [[-1]]],
            [   5,    [[1, 2], [3, 4]]],
            [  15,    [[8, 1, 6], [3, 5, 7], [4, 9, 2]]],
            [  17,    [[9, -6, 7], [-9, 4, 0], [-8, -6, 4]]],
            [  15.8,  [[1.2, -2.3, 3.4], [-4.5, 5.6, -6.7], [7.8, -8.9, 9.0]]],
            [ -15.91, [[-1.23, 2.34, -3.45], [4.56, -5.67, 6.78], [-7.89, 8.90, -9.01]]],
            [  34,    [[1, 15, 14, 4], [12, 6, 7, 9], [8, 10, 11, 5], [13, 3, 2, 16]]],
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
        $this->expectExceptionMessage('Trace can only be extracted from a square matrix');

        $matrix = new Matrix([[1,2,3], [4,5,6]]);
        $result = $matrix->trace();
    }
}
