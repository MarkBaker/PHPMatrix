<?php

namespace Matrix\Decomposition;

use Matrix\Matrix;

class LU
{
    private $LU;
    private $rows;
    private $columns;

    private $pivot = [];

    public function __construct(Matrix $matrix)
    {
        $this->LU = $matrix->toArray();
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
                    $lower[$row][$column] = $this->LU[$row][$column];
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
                    $upper[$row][$column] = $this->LU[$row][$column];
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
        $p = [];

        $pivots = $this->pivot;
        $pivotCount = count($pivots);
        foreach ($pivots as $row => $pivot) {
            $p[$row] = array_fill(0, $pivotCount - 1, 0);
            $p[$row][$pivot] = 1;
        }

        return new Matrix($p);
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
            if ($this->LU[$diagonal][$diagonal] === 0.0) {
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
            $LUcolumn = $this->localisedReferenceColumn($column);

            $this->applyTransformations($column, $LUcolumn);

            $pivot = $this->findPivot($column, $LUcolumn);
            if ($pivot != $column) {
                $this->pivotExchange($pivot, $column);
            }

            $this->computeMultipliers($column);

            unset($LUcolumn);
        }
    }


    private function localisedReferenceColumn($column)
    {
        $LUcolumn = [];

        for ($row = 0; $row < $this->rows; ++$row) {
            $LUcolumn[$row] = &$this->LU[$row][$column];
        }

        return $LUcolumn;
    }


    private function applyTransformations($column, array $LUcolumn)
    {
        for ($row = 0; $row < $this->rows; ++$row) {
            $LUrow = $this->LU[$row];
            // Most of the time is spent in the following dot product.
            $kmax = min($row, $column);
            $s = 0.0;
            for ($k = 0; $k < $kmax; ++$k) {
                $s += $LUrow[$k] * $LUcolumn[$k];
            }
            $LUrow[$column] = $LUcolumn[$row] -= $s;
        }
    }

    private function findPivot($column, array $LUcolumn)
    {
        $pivot = $column;
        for ($row = $column + 1; $row < $this->rows; ++$row) {
            if (abs($LUcolumn[$row]) > abs($LUcolumn[$pivot])) {
                $pivot = $row;
            }
        }

        return $pivot;
    }

    private function pivotExchange($pivot, $column)
    {
        for ($k = 0; $k < $this->columns; ++$k) {
            $t = $this->LU[$pivot][$k];
            $this->LU[$pivot][$k] = $this->LU[$column][$k];
            $this->LU[$column][$k] = $t;
        }

        $l = $this->pivot[$pivot];
        $this->pivot[$pivot] = $this->pivot[$column];
        $this->pivot[$column] = $l;
    }

    private function computeMultipliers($diagonal)
    {
        if (($diagonal < $this->rows) && ($this->LU[$diagonal][$diagonal] != 0.0)) {
            for ($row = $diagonal + 1; $row < $this->rows; ++$row) {
                $this->LU[$row][$diagonal] /= $this->LU[$diagonal][$diagonal];
            }
        }
    }
}
