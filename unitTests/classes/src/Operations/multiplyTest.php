<?php

namespace MatrixTest\Operations;

use Matrix\Exception;
use Matrix\Matrix;
use Matrix\Operations;
use MatrixTest\BaseTestAbstract;

class multiplyTest extends BaseTestAbstract
{
    protected static $operationName = 'multiplication';

    /**
     * @dataProvider dataProvider
     */
    public function testMultiplicationFunctionStatic($expected, $value1, $value2)
    {
        $result = Operations::multiply($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertSame($expected, $result->toArray());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testMultiplicationInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->multiply($value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrix);
        //    ... containing the correct data
        $this->assertSame($expected, $result->toArray());
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($value1, $matrix);
    }

    public function dataProvider()
    {
        return [
            'square - 2x2 * 2x2' => [
                [[-14, 20], [-30, 44]],
                [[1, 2], [3, 4]],
                [[-2, 4], [-6, 8]],
            ],
            'row vector/column vector' => [
                [[32]],
                [[1, 2, 3]],
                [[4], [5], [6]],
            ],
            'column vector/row vector' => [
                [[4, 5, 6], [8, 10, 12], [12, 15, 18]],
                [[1], [2], [3]],
                [[4, 5, 6]],
            ],
            'matrix 3x2 + 2x3' => [
                [[50, 68], [122,167]],
                [[1, 2, 3], [4, 5, 6]],
                [[7, 10], [8, 11], [9, 12]],
            ],
            'matrix 2x3 / 3x2' => [
                [[47, 52, 57], [64, 71, 78], [81, 90, 99]],
                [[1, 4], [2, 5], [3, 6]],
                [[7, 8, 9], [10, 11, 12]],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderException
     */
    public function testMultiplicationException($value1, $value2)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');

        Operations::multiply($value1, $value2);
    }

    public function dataProviderException()
    {
        return [
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
