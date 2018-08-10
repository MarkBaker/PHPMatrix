<?php

namespace Matrix\Operators;

use \Matrix\Matrix;
use Matrix\Exception;
use \Matrix\BaseTestAbstract;

class AdditionTest extends BaseTestAbstract
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
            [2, 7, 6],
            [9, 5, 1],
            [4, 3, 8],
        ]);
    }

    protected function getTestMatrix3()
    {
        return new Matrix([
            [1, 2],
            [3, 4],
        ]);
    }

    public function testGetResult()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $result = (new Addition($matrix))
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($original), count($original[0]), $original);
    }

    public function testAddInvalid()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid argument for addition');

        $result = $adder->execute("ElePHPant")
            ->result();
    }

    /**
     * @dataProvider scalarAdditionProvider
     */
    public function testAddScalar($original, $addition, $expected)
    {
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $result = $adder->execute($addition)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertOriginalMatrixIsUnchanged($original, $matrix, 'Original Matrix has mutated');
    }

    public function scalarAdditionProvider()
    {
        return [
            [$this->getTestGrid1(), 5, [[6, 7, 8], [9, 10, 11], [12, 13, 14]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], -3.21, [[-4.31, -1.01, -6.51], [1.19, -8.71, 3.39]]],
        ];
    }

    /**
     * @dataProvider matrixAdditionProvider
     */
    public function testAddMatrix($original, $addition, $expected)
    {
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $result = $adder->execute($addition)
            ->result();

        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($result);
        //    ... containing the correct data
        $this->assertMatrixValues($result, count($expected), count($expected[0]), $expected);
        // Ensure that original matrix remains unchanged (Immutable object)
        $this->assertEquals($original, $matrix->toArray(), 'Original Matrix has mutated');
    }

    public function matrixAdditionProvider()
    {
        return [
            [$this->getTestGrid1(), $this->getTestMatrix2(), [[3, 9, 9], [13, 10, 7], [11, 11, 17]]],
            [[[-1.1, 2.2, -3.3], [4.4, -5.5, 6.6]], [[9.9, -8.8, 7.7], [-6.6, 5.5, -4.4]], [[8.8, -6.6, 4.4], [-2.2, 0.0, 2.2]]],
        ];
    }

    public function testAddMismatchedMatrices()
    {
        $original = $this->getTestGrid1();
        $matrix = new Matrix($original);

        $adder = new Addition($matrix);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Matrices have mismatched dimensions');
        $result = $adder->execute($this->getTestMatrix3())
            ->result();
    }
}
