<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class dividebyTest extends BaseTestAbstract
{
    protected static $operationName = 'divideby';

    /**
     * @dataProvider dataProvider
     */
    public function testDivideByFunction($expected, $value1, $value2)
    {
        $result = divideby($value1, $value2);

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
                [[2.5, -1.0], [6.0, -2.5]],
                [[1, 2], [3, 4]], [[-2, 4], [-6, 8]],
            ],
        ];
    }
}
