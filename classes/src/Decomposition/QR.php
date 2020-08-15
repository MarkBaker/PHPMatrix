<?php

namespace Matrix\Decomposition;

use Matrix\Matrix;

class QR
{
    private $qrMatrix;
    private $rows;
    private $columns;

    private $rDiagonal = [];

    public function __construct(Matrix $matrix)
    {
        $this->qrMatrix = $matrix->toArray();
        $this->rows = $matrix->rows;
        $this->columns = $matrix->columns;

        $this->decompose();
    }

    public function getQ()
    {
        $qGrid = [];

        for ($k = $this->columns - 1; $k >= 0; --$k) {
            for ($i = 0; $i < $this->rows; ++$i) {
                $qGrid[$i][$k] = 0.0;
            }
            $qGrid[$k][$k] = 1.0;

            for ($j = $k; $j < $this->columns; ++$j) {
                if (isset($this->qrMatrix[$k][$k]) && $this->qrMatrix[$k][$k] !== 0.0) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->rows; ++$i) {
                        $s += $this->qrMatrix[$i][$k] * $qGrid[$i][$j];
                    }
                    $s = -$s / $this->qrMatrix[$k][$k];
                    for ($i = $k; $i < $this->rows; ++$i) {
                        $qGrid[$i][$j] += $s * $this->qrMatrix[$i][$k];
                    }
                }
            }
        }

        array_walk(
            $qGrid,
            function (&$row) {
                $row = array_reverse($row);
                $row[] = -1.0 * array_pop($row);
            }
        );

        return new Matrix($qGrid);
    }

    public function getR()
    {
        $rGrid = [];

        for ($column = 0; $column < $this->columns; ++$column) {
            for ($row = 0; $row < $this->rows; ++$row) {
                if ($column < $row) {
                    $rGrid[$column][$row] = isset($this->qrMatrix[$column][$row]) ? $this->qrMatrix[$column][$row] : 0.0;
                } elseif ($column === $row) {
                    $rGrid[$column][$row] = $this->rDiagonal[$column];
                } else {
                    $rGrid[$column][$row] = 0.0;
                }
            }
        }

        return new Matrix($rGrid);
    }

    private function hypo($a, $b)
    {
        if (abs($a) > abs($b)) {
            $r = $b / $a;
            $r = abs($a) * sqrt(1 + $r * $r);
        } elseif ($b != 0) {
            $r = $a / $b;
            $r = abs($b) * sqrt(1 + $r * $r);
        } else {
            $r = 0.0;
        }

        return $r;
    }

    private function decompose()
    {
        for ($k = 0; $k < $this->columns; ++$k) {
            // Compute 2-norm of k-th column without under/overflow.
            $nrm = 0.0;
            for ($i = $k; $i < $this->rows; ++$i) {
                $nrm = $this->hypo($nrm, $this->qrMatrix[$i][$k]);
            }
            if ($nrm !== 0.0) {
                // Form k-th Householder vector.
                if ($this->qrMatrix[$k][$k] < 0.0) {
                    $nrm = -$nrm;
                }
                for ($i = $k; $i < $this->rows; ++$i) {
                    $this->qrMatrix[$i][$k] /= $nrm;
                }
                $this->qrMatrix[$k][$k] += 1.0;
                // Apply transformation to remaining columns.
                for ($j = $k + 1; $j < $this->columns; ++$j) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->rows; ++$i) {
                        $s += $this->qrMatrix[$i][$k] * $this->qrMatrix[$i][$j];
                    }
                    $s = -$s / $this->qrMatrix[$k][$k];
                    for ($i = $k; $i < $this->rows; ++$i) {
                        $this->qrMatrix[$i][$j] += $s * $this->qrMatrix[$i][$k];
                    }
                }
            }
            $this->rDiagonal[$k] = -$nrm;
        }
    }
}
