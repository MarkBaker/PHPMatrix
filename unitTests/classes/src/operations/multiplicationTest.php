<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class multiplicationTest extends BaseTestAbstract
{
    protected static $operationName = 'multiplication';

    /**
     * @dataProvider dataProvider
     */
    public function testMultiplicationFunction($expected, $value1, $value2)
    {
        $result = multiply($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
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
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($value1, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                [[-14, 20], [-30, 44]],
                [[1, 2], [3, 4]], [[-2, 4], [-6, 8]],
            ],
        ];
    }
}
