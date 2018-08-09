<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class identityTest extends BaseTestAbstract
{
    protected static $functionName = 'identity';

    /**
     * @dataProvider dataProvider
     */
    public function testIdentity($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = Functions::identity($matrix);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testIdentityFunction($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = identity($matrix);

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProviderSingle
     */
    public function testIdentityInvoker($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $result = $matrix->identity();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrix);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    public function dataProvider()
    {
        return [
            [
                [[1]],
                [[1]],
            ],
            [
                [[1, null], [null, 1]],
                [[1, 2], [3, 4]],
            ],
            [
                [[1, null, null], [null, 1, null], [null, null, 1]],
                [[8, 1, 6], [3, 5, 7], [4, 9, 2]],
            ],
        ];
    }

    public function dataProviderSingle()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }

    public function testIdentityInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Identity can only be created for a square matrix');

        $matrix = new Matrix([[1,2,3], [4,5,6]]);
        $result = $matrix->identity();
    }
}
