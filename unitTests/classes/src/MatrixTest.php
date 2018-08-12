<?php

namespace Matrix;

use Matrix\Matrix as Matrix;

class MatrixTest extends BaseTestAbstract
{
    public function testInstantiate()
    {
        $cells = 21;
        $columns = 7;

        $matrixObject = new Matrix($this->buildArray($cells, $columns));
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixObject);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixObject, ceil($cells / $columns), $columns, $this->buildArray($cells, $columns));
    }

    public function testRowsDefault()
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixRows = $matrixObject->getRows(2);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixRows);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixRows, 1, 4, [[5, 10, 11, 8]]);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    /**
     * @dataProvider rowsDataProvider
     */
    public function testRows($startRow, $rows, $grid)
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixRows = $matrixObject->getRows($startRow, $rows);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixRows);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixRows, count($grid), 4, $grid);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    public function rowsDataProvider()
    {
        return [
            [ 2,  2, [[ 5, 10, 11,  8], [ 9,  6,  7, 12]]],
            [ 2, -1, [[ 5, 10, 11,  8], [ 9,  6,  7, 12]]],
            [ 3,  0, [[ 9,  6,  7, 12], [ 4, 15, 14,  1]]],
        ];
    }

    public function testColumnsDefault()
    {
        $columns = 1;
        $matrixObject = new Matrix($this->getMagic());

        $matrixColumns = $matrixObject->getColumns(2);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixColumns);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixColumns, 4, 1, [[3], [10], [6], [15]]);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    /**
     * @dataProvider columnsDataProvider
     */
    public function testColumns($startColumn, $columns, $grid)
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixColumns = $matrixObject->getColumns($startColumn, $columns);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixColumns);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixColumns, 4, count($grid[0]), $grid);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    public function columnsDataProvider()
    {
        return [
            [ 2,  2, [[3,  2], [10, 11], [6,  7], [15, 14]]],
            [ 2, -1, [[3,  2], [10, 11], [6,  7], [15, 14]]],
            [ 3,  0, [[2, 13], [11,  8], [7, 12], [14,  1]]],
        ];
    }

    public function testDropRowsDefault()
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixRows = $matrixObject->dropRows(2);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixRows);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixRows, 3, 4, [[16, 3, 2, 13], [9, 6, 7, 12], [4, 15, 14, 1]]);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    /**
     * @dataProvider dropRowsDataProvider
     */
    public function testDropRows($startRow, $rows, $grid)
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixRows = $matrixObject->dropRows($startRow, $rows);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixRows);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixRows, count($grid), 4, $grid);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    public function dropRowsDataProvider()
    {
        return [
            [ 2,  2, [[16,  3,  2, 13], [ 4, 15, 14,  1]]],
            [ 2, -1, [[16,  3,  2, 13], [ 4, 15, 14,  1]]],
            [ 3, 0,  [[16,  3,  2, 13], [ 5, 10, 11,  8]]],
        ];
    }

    public function testDropColumnsDefault()
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixColumns = $matrixObject->dropColumns(2);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixColumns);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixColumns, 4, 3, [[16, 2, 13], [5, 11, 8], [9, 7, 12], [4, 14, 1]]);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    /**
     * @dataProvider dropColumnsDataProvider
     */
    public function testDropColumns($startColumn, $columns, $grid)
    {
        $matrixObject = new Matrix($this->getMagic());

        $matrixColumns = $matrixObject->dropColumns($startColumn, $columns);
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($matrixColumns);
        //    ... containing the correct data
        $this->assertMatrixValues($matrixColumns, 4, count($grid[0]), $grid);
        // And the original Matrix object must remain unchanged
        $this->assertOriginalMatrixIsUnchanged($this->getMagic(), $matrixObject);
    }

    public function dropColumnsDataProvider()
    {
        return [
            [ 2,  2, [[16, 13], [5,  8], [9, 12], [4,  1]]],
            [ 2, -1, [[16, 13], [5,  8], [9, 12], [4,  1]]],
            [ 3, 0,  [[16,  3], [5, 10], [9,  6], [4, 15]]],
        ];
    }

    /**
     * @dataProvider isSquareDataProvider
     */
    public function testIsSquare($expected, $grid)
    {
        $matrixObject = new Matrix($grid);

        $result = $matrixObject->isSquare();
        $this->assertEquals($expected, $result);
    }

    public function isSquareDataProvider()
    {
        return [
            [ false, [[1, 2, 3]]],
            [ false, [[1], [2], [3]]],
            [ true,  [[1, 2], [3, 4]]],
            [ true,  [[1, 2, 3], [4, 5, 6], [7, 8, 9]]],
            [ false, [[1, 2, 3], [4, 5, 6]]],
        ];
    }

    /**
     * @dataProvider isVectorDataProvider
     */
    public function testIsVector($expected, $grid)
    {
        $matrixObject = new Matrix($grid);

        $result = $matrixObject->isVector();
        $this->assertEquals($expected, $result);
    }

    public function isVectorDataProvider()
    {
        return [
            [ true, [[1, 2, 3]]],
            [ true, [[1], [2], [3]]],
            [ false,  [[1, 2], [3, 4]]],
            [ false,  [[1, 2, 3], [4, 5, 6], [7, 8, 9]]],
            [ false, [[1, 2, 3], [4, 5, 6]]],
        ];
    }

    public function testRowColumnIterator()
    {
        $grid = $this->getMagic();
        $matrixObject = new Matrix($grid);
        $rowIteratorObject = $matrixObject->rows();

        //    Must return an object...
        $this->assertTrue(is_object($rowIteratorObject));
        //    ... of the correct type
        $this->assertTrue(is_a($rowIteratorObject, 'Generator'));

        $rowReference = 1;
        foreach ($rowIteratorObject as $row => $rowObject) {
            $this->assertEquals($rowReference++, $row, 'Row index mismatched');
            //    Must return an object of the correct type...
            $this->assertIsMatrixObject($rowObject);
            $this->assertTrue($rowObject->isVector());

            $columnIteratorObject = $rowObject->columns();

            //    Must return an object...
            $this->assertTrue(is_object($columnIteratorObject));
            //    ... of the correct type
            $this->assertTrue(is_a($columnIteratorObject, 'Generator'));

            $columnReference = 1;
            foreach ($columnIteratorObject as $column => $columnValue) {
                $this->assertEquals($columnReference++, $column, 'Column index mismatched against row vector');
                $this->assertTrue(is_scalar($columnValue));
                $this->assertEquals($grid[$row - 1][$column - 1], $columnValue);
            }
        }
    }

    public function testColumnRowIterator()
    {
        $grid = $this->getMagic();
        $matrixObject = new Matrix($grid);
        $columnIteratorObject = $matrixObject->columns();

        //    Must return an object...
        $this->assertTrue(is_object($columnIteratorObject));
        //    ... of the correct type
        $this->assertTrue(is_a($columnIteratorObject, 'Generator'));

        $columnReference = 1;
        foreach ($columnIteratorObject as $column => $columnObject) {
            $this->assertEquals($columnReference++, $column, 'Column index mismatched');
            //    Must return an object of the correct type...
            $this->assertIsMatrixObject($columnObject);
            $this->assertTrue($columnObject->isVector());

            $rowIteratorObject = $columnObject->rows();

            //    Must return an object...
            $this->assertTrue(is_object($rowIteratorObject));
            //    ... of the correct type
            $this->assertTrue(is_a($rowIteratorObject, 'Generator'));

            $rowReference = 1;
            foreach ($rowIteratorObject as $row => $rowValue) {
                $this->assertEquals($rowReference++, $row, 'Row index mismatched against column vector');
                $this->assertTrue(is_scalar($rowValue));
                $this->assertEquals($grid[$row - 1][$column - 1], $rowValue);
            }
        }
    }

    protected function getMagic()
    {
        return [
            [16,  3,  2, 13],
            [ 5, 10, 11,  8],
            [ 9,  6,  7, 12],
            [ 4, 15, 14,  1]
        ];
    }

    protected function buildArray($size, $columns = null)
    {
        if ($columns === null) {
            $columns = ceil(sqrt($size));
        }

        return array_chunk(
            range(1, $size),
            $columns
        );
    }
}
