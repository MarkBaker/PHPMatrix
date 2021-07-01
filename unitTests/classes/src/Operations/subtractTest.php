<?php

namespace MatrixTest\Operations;

use Matrix\Matrix;
use Matrix\Operations;
use MatrixTest\BaseTestAbstract;
use function Matrix\subtract;

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
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
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
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($value1, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                [[3, -2], [9, -4]],
                [[1, 2], [3, 4]], [[-2, 4], [-6, 8]],
            ],
        ];
    }
}
