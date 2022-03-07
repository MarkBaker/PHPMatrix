<?php

namespace MatrixTest\Operations;

use Matrix\Exception;
use Matrix\Matrix;
use Matrix\Operations;
use MatrixTest\BaseTestAbstract;

class subtractTest extends BaseTestAbstract
{
    protected static $operationName = 'subtraction';

    /**
     * @dataProvider dataProvider
     */
    public function testSubtractionFunctionStatic($expected, $value1, $value2)
    {
        $result = Operations::subtract($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertSame($expected, $result->toArray());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSubtractionInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->subtract($value2);

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
            'square - 2x2 - 2x2' => [
                [[3, -2], [9, -4]],
                [[1, 2], [3, 4]],
                [[-2, 4], [-6, 8]],
            ],
            'row vector/row vector' => [
                [[-3, -3, -3]],
                [[1, 2, 3]],
                [[4, 5, 6]],
            ],
            'column vector/column vector' => [
                [[-3], [-3], [-3]],
                [[1], [2], [3]],
                [[4], [5], [6]],
            ],
            'matrix 3x2 + 3x2' => [
                [[-6, -6, -6], [-6, -6, -6]],
                [[1, 2, 3], [4, 5, 6]],
                [[7, 8, 9], [10, 11, 12]],
            ],
            'matrix 2x3 / 2x3' => [
                [[-6, -6], [-6, -6], [-6, -6]],
                [[1, 4], [2, 5], [3, 6]],
                [[7, 10], [8, 11], [9, 12]],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderException
     */
    public function testSubtractionException($value1, $value2)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');

        Operations::subtract($value1, $value2);
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
        ];
    }
}
