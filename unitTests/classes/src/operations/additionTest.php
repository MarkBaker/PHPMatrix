<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class additionTest extends BaseTestAbstract
{
    protected static $operationName = 'addition';

    /**
     * @dataProvider dataProvider
     */
    public function testAdditionFunction($expected, $value1, $value2)
    {
        $result = add($value1, $value2);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAdditionInvoker($expected, $value1, $value2)
    {
        $matrix = new Matrix($value1);
        $result = $matrix->add($value2);

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
                [[-1, 6], [-3, 12]],
                [[1, 2], [3, 4]], [[-2, 4], [-6, 8]],
            ],
        ];
    }
}
