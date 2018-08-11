<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class divideintoTest extends BaseTestAbstract
{
    protected static $operationName = 'divideinto';

    /**
     * @dataProvider dataProvider
     */
    public function testDivideIntoFunction($expected, $value1, $value2)
    {
        $result = divideinto($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDivideIntoInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->divideinto($value2);

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
                [[10, -4], [24, -10]],
                [[1, 2], [3, 4]], [[-2, 4], [-6, 8]],
            ],
        ];
    }
}
