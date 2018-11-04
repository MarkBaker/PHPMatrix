<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class DirectSumTest extends BaseTestAbstract
{
    protected function getTestGrid1()
    {
        return [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ];
    }

    protected function getTestMatrix2()
    {
        return new Matrix([
            [1, 2],
            [3, 4],
        ]);
    }

    /**
     * @dataProvider matrixDirectSumProvider
     */
    public function testDirectSumMatrix($original, $sum, $expected)
    {
        $matrix = new Matrix($original);

        $summer = new DirectSum($matrix);

        $result = $summer->execute($sum)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function matrixDirectSumProvider()
    {
        return [
            [
                $this->getTestGrid1(),
                $this->getTestMatrix2(),
                [[1, 2, 3, 0, 0], [4, 5, 6, 0, 0], [7, 8, 9, 0, 0], [0, 0, 0, 1, 2], [0, 0, 0, 3, 4]]
            ],
        ];
    }
}
