<?php

namespace Matrix\Decomposition;

use Matrix\Matrix;

class LU
{
    private $luMatrix;
    private $rows;
    private $columns;

    private $pivot = [];

    public function __construct(Matrix $matrix)
    {
        $this->luMatrix = $matrix->toArray();
        $this->rows = $matrix->rows;
        $this->columns = $matrix->columns;

        $this->buildPivot();
    }

    /**
     * Get lower triangular factor.
     *
     * @return Matrix Lower triangular factor
     */
    public function getL()
    {
        $lower = [];

        $columns = min($this->rows, $this->columns);
        for ($row = 0; $row < $this->rows; ++$row) {
            for ($column = 0; $column < $columns; ++$column) {
                if ($row > $column) {
                    $lower[$row][$column] = $this->luMatrix[$row][$column];
                } elseif ($row === $column) {
                    $lower[$row][$column] = 1.0;
                } else {
                    $lower[$row][$column] = 0.0;
                }
            }
        }

        return new Matrix($lower);
    }

    /**
     * Get upper triangular factor.
     *
     * @return Matrix Upper triangular factor
     */
    public function getU()
    {
        $upper = [];

        $rows = min($this->rows, $this->columns);
        for ($row = 0; $row < $rows; ++$row) {
            for ($column = 0; $column < $this->columns; ++$column) {
                if ($row <= $column) {
                    $upper[$row][$column] = $this->luMatrix[$row][$column];
                } else {
                    $upper[$row][$column] = 0.0;
                }
            }
        }

        return new Matrix($upper);
    }

    /**
     * Return pivot permutation vector.
     *
     * @return Matrix Pivot matrix
     */
    public function getP()
    {
        $pMatrix = [];

        $pivots = $this->pivot;
        $pivotCount = count($pivots);
        foreach ($pivots as $row => $pivot) {
            $pMatrix[$row] = array_fill(0, $pivotCount, 0);
            $pMatrix[$row][$pivot] = 1;
        }

        return new Matrix($pMatrix);
    }

    /**
     * Return pivot permutation vector.
     *
     * @return array Pivot vector
     */
    public function getPivot()
    {
        return $this->pivot;
    }

    /**
     *    Is the matrix nonsingular?
     *
     * @return bool true if U, and hence A, is nonsingular
     */
    public function isNonsingular()
    {
        for ($diagonal = 0; $diagonal < $this->columns; ++$diagonal) {
            if ($this->luMatrix[$diagonal][$diagonal] === 0.0) {
                return false;
            }
        }

        return true;
    }

    private function buildPivot()
    {
        for ($row = 0; $row < $this->rows; ++$row) {
            $this->pivot[$row] = $row;
        }

        for ($column = 0; $column < $this->columns; ++$column) {
            $luColumn = $this->localisedReferenceColumn($column);

            $this->applyTransformations($column, $luColumn);

            $pivot = $this->findPivot($column, $luColumn);
            if ($pivot !== $column) {
                $this->pivotExchange($pivot, $column);
            }

            $this->computeMultipliers($column);

            unset($luColumn);
        }
    }

    private function localisedReferenceColumn($column)
    {
        $luColumn = [];

        for ($row = 0; $row < $this->rows; ++$row) {
            $luColumn[$row] = &$this->luMatrix[$row][$column];
        }

        return $luColumn;
    }

    private function applyTransformations($column, array $luColumn)
    {
        for ($row = 0; $row < $this->rows; ++$row) {
            $luRow = $this->luMatrix[$row];
            // Most of the time is spent in the following dot product.
            $kmax = min($row, $column);
            $sValue = 0.0;
            for ($kValue = 0; $kValue < $kmax; ++$kValue) {
                $sValue += $luRow[$kValue] * $luColumn[$kValue];
            }
            $luRow[$column] = $luColumn[$row] -= $sValue;
        }
    }

    private function findPivot($column, array $luColumn)
    {
        $pivot = $column;
        for ($row = $column + 1; $row < $this->rows; ++$row) {
            if (abs($luColumn[$row]) > abs($luColumn[$pivot])) {
                $pivot = $row;
            }
        }

        return $pivot;
    }

    private function pivotExchange($pivot, $column)
    {
        for ($kValue = 0; $kValue < $this->columns; ++$kValue) {
            $tValue = $this->luMatrix[$pivot][$kValue];
            $this->luMatrix[$pivot][$kValue] = $this->luMatrix[$column][$kValue];
            $this->luMatrix[$column][$kValue] = $tValue;
        }

        $lValue = $this->pivot[$pivot];
        $this->pivot[$pivot] = $this->pivot[$column];
        $this->pivot[$column] = $lValue;
    }

    private function computeMultipliers($diagonal)
    {
        if (($diagonal < $this->rows) && ($this->luMatrix[$diagonal][$diagonal] != 0.0)) {
            for ($row = $diagonal + 1; $row < $this->rows; ++$row) {
                $this->luMatrix[$row][$diagonal] /= $this->luMatrix[$diagonal][$diagonal];
            }
        }
    }
}
