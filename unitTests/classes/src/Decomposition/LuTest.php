<?php

namespace MatrixTest\Decomposition;

use Matrix\Decomposition\LU;
use Matrix\Matrix as Matrix;
use MatrixTest\BaseTestAbstract;

class LuTest extends BaseTestAbstract
{
    public function testBasicLUDecomposition()
    {
        $grid = [
            [1, -2],
            [-3, 4]
        ];

        $matrix = new Matrix($grid);
        new LU($matrix);

        // Verify that the original matrix remains unchanged
        $this->assertOriginalMatrixIsUnchanged($grid, $matrix);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLUDecompositionL($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);

        $L = $decomposition->getL();
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($L);
        //    ... containing the correct data
        $this->assertMatrixValues($L, count($expected['L']), count($expected['L'][0]), $expected['L']);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLUDecompositionU($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);

        $U = $decomposition->getU();
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($U);
        //    ... containing the correct data
        $this->assertMatrixValues($U, count($expected['U']), count($expected['U'][0]), $expected['U']);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLUDecompositionPivots($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);

        $pivots = $decomposition->getPivot();
        $this->assertEqualsWithDelta($expected['pivots'], $pivots, self::PRECISION);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLUDecompositionP($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);

        $P = $decomposition->getP();
        //    Must return an object of the correct type...
        $this->assertIsMatrixObject($P);
        //    ... containing the correct data
        $this->assertMatrixValues($P, count($expected['P']), count($expected['P'][0]), $expected['P']);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLUDecompositionResolve($expected, $grid)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);

        $L = $decomposition->getL();
        $U = $decomposition->getU();
        $P = $decomposition->getP();

        $result1 = $P->inverse()->multiply($L->multiply($U));
        $this->assertEqualsWithDelta($matrix, $result1, self::PRECISION);

        $matrix2 = $P->multiply($matrix);
        $result2 = $L->multiply($U);
        $this->assertEqualsWithDelta($matrix2, $result2, self::PRECISION);
    }

    /**
     * @dataProvider solveDataProvider
     */
    public function testLUDecompositionSolve($expected, $grid, $target)
    {
        $matrix = new Matrix($grid);
        $decomposition = new LU($matrix);
        $target = new Matrix($target);

        $result = $decomposition->solve($target);
        $this->assertEqualsWithDelta($expected, $result->toArray(), self::PRECISION);

        $resolve = $matrix->multiply($result);
        $this->assertEqualsWithDelta($target, $resolve, self::PRECISION);
    }

    public function solveDataProvider()
    {
        return [
            [
                [
                    [-4],
                    [4.5],
                ],
                [
                    [1, 2],
                    [3, 4],
                ],
                [
                    [5],
                    [6],
                ],
            ],
            [
                [
                    [-4, -6],
                    [4.5, 6.5],
                ],
                [
                    [1, 2],
                    [3, 4],
                ],
                [
                    [5, 7],
                    [6, 8],
                ],
            ],
            [
                [
                    [-4, -6, -18],
                    [4.5, 6.5, 13.5],
                ],
                [
                    [1, 2],
                    [3, 4],
                ],
                [
                    [5, 7, 9],
                    [6, 8, 0],
                ],
            ],
            [
                [
                    [5],
                    [3],
                    [-2]
                ],
                [
                    [1, 1, 1],
                    [0, 2, 5],
                    [2, 5, -1],
                ],
                [
                    [6],
                    [-4],
                    [27],
                ],
            ],
            [
                [
                    [-0.36363636363636476],
                    [0.9545454545454576],
                    [-0.31818181818182023]
                ],
                [
                    [-1, 2, 4],
                    [5, 6, 6],
                    [-3, 5, 9],
                ],
                [
                    [1],
                    [2],
                    [3],
                ],
            ],
            [
                [
                    [1.5],
                    [-3.5],
                    [0.5],
                    [0.0],
                ],
                [
                    [1, 0, 1, 0],
                    [2, 0, 0, 2],
                    [0, -1, 1, 0],
                    [0, -2, 0, -2],
                ],
                [
                    [2],
                    [3],
                    [4],
                    [7],
                ],
            ],
            [
                [
                    [1.5, 0.0],
                    [-3.5, -4.0],
                    [0.5, 1.0],
                    [0.0, 0.0],
                ],
                [
                    [1, 0, 1, 0],
                    [2, 0, 0, 2],
                    [0, -1, 1, 0],
                    [0, -2, 0, -2],
                ],
                [
                    [2, 1],
                    [3, 0],
                    [4, 5],
                    [7, 8],
                ],
            ],
        ];
    }

    public function dataProvider()
    {
        return [
            'Simple 2x2' => [
                [
                    'U' => [
                        [3, 4],
                        [0, 0.666666666667],
                    ],
                    'L' => [
                        [1, 0],
                        [0.333333333333, 1],
                    ],
                    'P' => [
                        [0, 1],
                        [1, 0],
                    ],
                    'pivots' => [1, 0],
                ],
                [
                    [1, 2],
                    [3, 4],
                ],
            ],
            'All the Ones' => [
                [
                    'U' => [
                        [1, 1, 1, 1],
                        [0, -2, -2, 0],
                        [0, 0, -2, -2],
                        [0, 0, 0, -4],
                    ],
                    'L' => [
                        [1, 0, 0, 0],
                        [1, 1, 0, 0],
                        [1, 0, 1, 0],
                        [1, 1, -1, 1],
                    ],
                    'P' => [
                        [1, 0, 0, 0],
                        [0, 0, 1, 0],
                        [0, 1, 0, 0],
                        [0, 0, 0, 1],
                    ],
                    'pivots' => [0, 2, 1, 3],
                ],
                [
                    [1, 1, 1, 1],
                    [1, 1, -1, -1],
                    [1, -1, -1, 1],
                    [1, -1, 1, -1],
                ],
            ],
            'Simple 3x3 Matrix' => [
                [
                    'U' => [
                        [7, 8, 9],
                        [0, 0.85714285714286, 1.7142857142857],
                        [0, 0, 5e-15],
                    ],
                    'L' => [
                        [1, 0, 0],
                        [0.14285714285714, 1, 0],
                        [0.57142857142857, 0.5, 1],
                    ],
                    'P' => [
                        [0, 0, 1],
                        [1, 0, 0],
                        [0, 1, 0],
                    ],
                    'pivots' => [2, 0, 1],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                ],
            ],
            '3x3 Magic Square' => [
                [
                    'U' => [
                        [9, 5, 1],
                        [0, 5.888888888888890, 5.777777777777780],
                        [0, 0, 6.792452830188680],
                    ],
                    'L' => [
                        [1, 0, 0],
                        [0.222222222222222, 1, 0],
                        [0.444444444444444, 0.132075471698113, 1],
                    ],
                    'P' => [
                        [0, 1, 0],
                        [1, 0, 0],
                        [0, 0, 1],
                    ],
                    'pivots' => [1, 0, 2],
                ],
                [
                    [2, 7, 6],
                    [9, 5, 1],
                    [4, 3, 8],
                ],
            ],
            'Another Simple 3x3' => [
                [
                    'U' => [
                        [2, 4, 7],
                        [0, 1, 1.5],
                        [0, 0, -2],
                    ],
                    'L' => [
                        [1, 0, 0],
                        [0.5, 1, 0],
                        [0.5, -1, 1],
                    ],
                    'P' => [
                        [0, 1, 0],
                        [1, 0, 0],
                        [0, 0, 1],
                    ],
                    'pivots' => [1, 0, 2],
                ],
                [
                    [1, 3, 5],
                    [2, 4, 7],
                    [1, 1, 0],
                ],
            ],
            '4x4 with positive and negative values' => [
                [
                    'U' => [
                        [5, -4, -3, 1],
                        [0, 5.6, 2.2, -3.4],
                        [0, 0, -2.6428571428571, 7.3571428571429],
                        [0, 0, 0, 9.4594594594595],
                    ],
                    'L' => [
                        [1, 0, 0, 0],
                        [0.4, 1, 0, 0],
                        [0.8, 0.92857142857143, 1, 0],
                        [-0.2, -0.5, -0.94594594594595, 1],
                    ],
                    'P' => [
                        [0, 0, 0, 1],
                        [1, 0, 0, 0],
                        [0, 0, 1, 0],
                        [0, 1, 0, 0],
                    ],
                    'pivots' => [3, 0, 2, 1],
                ],
                [
                    [2, 4, 1, -3],
                    [-1, -2, 2, 4],
                    [4, 2, -3, 5],
                    [5, -4, -3, 1],
                ],
            ],
            '4x4 with positive and negative float values' => [
                [
                    'U' => [
                        [-2.5, -1, 0, 1],
                        [0, 2.1, 5, 12.4],
                        [0, 0, 0.11904761904762, -0.9047619047619],
                        [0, 0, 0, 0.10000000000002],
                    ],
                    'L' => [
                        [1, 0, 0, 0],
                        [-0.4, 1, 0, 0],
                        [0, 0.47619047619048, 1, 0],
                        [0.4, 0.19047619047619, 0.40000000000002, 1],
                    ],
                    'P' => [
                        [1, 0, 0, 0],
                        [0, 0, 0, 1],
                        [0, 0, 1, 0],
                        [0, 1, 0, 0],
                    ],
                    'pivots' => [0, 3, 2, 1],
                ],
                [
                    [-2.5, -1, 0, 1],
                    [-1, 0, 1, 2.5],
                    [0, 1, 2.5, 5],
                    [1, 2.5, 5, 12],
                ],
            ],
            '4x4 Magic square' =>[
                [
                    'U' => [
                        [14, 1, 8, 11],
                        [0, 14.714285714286, 7.714285714286, 1.857142857143],
                        [0, 0, -4.951456310680, 8.252427184466],
                        [0, 0, 0, 0],
                    ],
                    'L' => [
                        [1, 0, 0, 0],
                        [0.285714285714, 1, 0, 0],
                        [0.642857142857, 0.364077669903, 1, 0],
                        [0.5, 0.781553398058, -0.6, 1],
                    ],
                    'P' => [
                        [0, 0, 1, 0],
                        [0, 1, 0, 0],
                        [1, 0, 0, 0],
                        [0, 0, 0, 1],
                    ],
                    'pivots' => [2, 1, 0, 3],
                ],
                [
                    [9, 6, 3, 16],
                    [4, 15, 10, 5],
                    [14, 1, 8, 11],
                    [7, 12, 13, 2],
                ],
            ],
            'Asymetric - 2 rows 3 columns' => [
                [
                    'U' => [
                        [4, 5, 6],
                        [0, 0.75, 1.5],
                    ],
                    'L' => [
                        [1, 0],
                        [0.25, 1],
                    ],
                    'P' => [
                        [0, 1],
                        [1, 0],
                    ],
                    'pivots' => [1, 0],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                ],
            ],
            'Asymetric - 3 rows 2 columns' => [
                [
                    'U' => [
                        [5, 6],
                        [0, 0.8],
                    ],
                    'L' => [
                        [1, 0],
                        [0.2, 1],
                        [0.6, 0.5],
                    ],
                    'P' => [
                        [0, 0, 1],
                        [1, 0, 0],
                        [0, 1, 0],
                    ],
                    'pivots' => [2, 0, 1],
                ],
                [
                    [1, 2],
                    [3, 4],
                    [5, 6],
                ],
            ],
            'Asymetric - 3 rows 7 columns' => [
                [
                    'U' => [
                        [9, 8, 7, 6, 5, 4, 3],
                        [0, 1.111111111111, 2.222222222222, 3.333333333333, 4.444444444444, 5.555555555556, 6.666666666667],
                        [0, 0, 0, 0, 0, 0, 0],
                    ],
                    'L' => [
                        [1, 0, 0],
                        [0.111111111111, 1, 0],
                        [-0.222222222222, 0.700, 1.000],
                    ],
                    'P' => [
                        [0, 1, 0],
                        [1, 0, 0],
                        [0, 0, 1],
                    ],
                    'pivots' => [1, 0, 2],
                ],
                [
                    [1, 2, 3, 4, 5, 6, 7],
                    [9, 8, 7, 6, 5, 4, 3],
                    [-2, -1, 0, 1, 2, 3, 4],
                ],
            ],
            'Asymetric - 7 rows 3 columns' => [
                [
                    'U' => [
                        [7, 9, 8],
                        [0, -3, -3],
                        [0, 0, -4.428571428571429],
                    ],
                    'L' => [
                        [1, 0, 0],
                        [1, 1, 0],
                        [0.5714285714285714, 0.7142857142857141, 1],
                        [0.5714285714285714, 0.04761904761904745, -0.35483870967741926],
                        [0.14285714285714285, -0.23809523809523814, -0.25806451612903225],
                        [-0.14285714285714285, -0.42857142857142855, -0.1935483870967742],
                        [0.2857142857142857, -0.14285714285714293, -0.29032258064516125],
                    ],
                    'P' => [
                        [0, 0, 1, 0, 0, 0, 0],
                        [0, 0, 0, 1, 0, 0, 0],
                        [0, 0, 0, 0, 1, 0, 0],
                        [0, 1, 0, 0, 0, 0, 0],
                        [1, 0, 0, 0, 0, 0, 0],
                        [0, 0, 0, 0, 0, 1, 0],
                        [0, 0, 0, 0, 0, 0, 1],
                    ],
                    'pivots' => [2, 3, 4, 1, 0, 5, 6],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 9, 8],
                    [7, 6, 5],
                    [4, 3, -2],
                    [-1, 0, 1],
                    [2, 3, 4],
                ],
            ],
        ];
    }
}
