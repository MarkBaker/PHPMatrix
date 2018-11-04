<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class directsumTest extends BaseTestAbstract
{
    protected static $operationName = 'directsum';

    /**
     * @dataProvider dataProvider
     */
    public function testDirectSumFunction($expected, $value1, $value2)
    {
        $result = directsum($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDirectSumInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->directsum($value2);

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
                [[1, 2, 3, 0, 0], [4, 5, 6, 0, 0], [0, 0, 0, 7, 8], [0, 0, 0, 9, 10]],
                [[1, 2, 3], [4, 5, 6]], [[7, 8], [9, 10]],
            ],
        ];
    }
}
