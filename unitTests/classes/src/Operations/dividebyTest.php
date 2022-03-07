<?php

namespace MatrixTest\Operations;

use Matrix\Exception;
use Matrix\Matrix;
use Matrix\Operations;
use MatrixTest\BaseTestAbstract;

class dividebyTest extends BaseTestAbstract
{
    protected static $operationName = 'divideby';

    /**
     * @dataProvider dataProvider
     */
    public function testDivideByFunctionStatic($expected, $value1, $value2)
    {
        $result = Operations::divideby($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDivideByInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->divideby($value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrix);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($value1, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                'square - 2x2 * 2x2' => [[2.5, -1.0], [6.0, -2.5]],
                [[1, 2], [3, 4]],
                [[-2, 4], [-6, 8]],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderException
     */
    public function testDivideByException($value1, $value2)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Division can only be calculated for a square matrix');

        Operations::divideby($value1, $value2);
    }

    public function dataProviderException()
    {
        return [
            'row vector/column vector' => [
                [[1, 2, 3]],
                [[4], [5], [6]],
            ],
            'column vector/row vector' => [
                [[1], [2], [3]],
                [[4, 5, 6]],
            ],
            'matrix 3x2 + 2x3' => [
                [[1, 2, 3], [4, 5, 6]],
                [[7, 10], [8, 11], [9, 12]],
            ],
            'matrix 2x3 / 3x2' => [
                [[1, 4], [2, 5], [3, 6]],
                [[7, 8, 9], [10, 11, 12]],
            ],
            'row vector/row vector' => [
                [[1, 2, 3]],
                [[4, 5, 6]],
            ],
            'column vector/column vector' => [
                [[1], [2], [3]],
                [[4], [5], [6]],
            ],
            'matrix 3x2 + 3x2' => [
                [[1, 2, 3], [4, 5, 6]],
                [[7, 8, 9], [10, 11, 12]],
            ],
            'matrix 2x3 / 2x3' => [
                [[1, 4], [2, 5], [3, 6]],
                [[7, 10], [8, 11], [9, 12]],
            ],
        ];
    }
}
