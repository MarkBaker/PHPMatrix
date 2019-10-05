<?php

namespace Matrix\Decomposition;

use Matrix\Matrix;

class QR
{
    private $QR;
    private $m;
    private $n;

    private $Rdiag = [];

    public function __construct(Matrix $matrix)
    {
        $this->QR = $matrix->toArray();
        $this->m = $matrix->rows;
        $this->n = $matrix->columns;

        $this->decompose();
    }

    public function getQ()
    {
        $Q = [];

        for ($k = $this->n - 1; $k >= 0; --$k) {
            for ($i = 0; $i < $this->m; ++$i) {
                $Q[$i][$k] = 0.0;
            }
            $Q[$k][$k] = 1.0;
            for ($j = $k; $j < $this->n; ++$j) {
                if ($this->QR[$k][$k] != 0) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->m; ++$i) {
                        $s += $this->QR[$i][$k] * $Q[$i][$j];
                    }
                    $s = -$s / $this->QR[$k][$k];
                    for ($i = $k; $i < $this->m; ++$i) {
                        $Q[$i][$j] += $s * $this->QR[$i][$k];
                    }
                }
            }
        }

        return new Matrix($Q);
    }

    public function getR()
    {
        $R = [];

        for ($i = 0; $i < $this->n; ++$i) {
            for ($j = 0; $j < $this->n; ++$j) {
                if ($i < $j) {
                    $R[$i][$j] = $this->QR[$i][$j];
                } elseif ($i == $j) {
                    $R[$i][$j] = $this->Rdiag[$i];
                } else {
                    $R[$i][$j] = 0.0;
                }
            }
        }

        return new Matrix($R);
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
        for ($k = 0; $k < $this->n; ++$k) {
            // Compute 2-norm of k-th column without under/overflow.
            $nrm = 0.0;
            for ($i = $k; $i < $this->m; ++$i) {
                $nrm = $this->hypo($nrm, $this->QR[$i][$k]);
            }
            if ($nrm != 0.0) {
                // Form k-th Householder vector.
                if ($this->QR[$k][$k] < 0) {
                    $nrm = -$nrm;
                }
                for ($i = $k; $i < $this->m; ++$i) {
                    $this->QR[$i][$k] /= $nrm;
                }
                $this->QR[$k][$k] += 1.0;
                // Apply transformation to remaining columns.
                for ($j = $k + 1; $j < $this->n; ++$j) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->m; ++$i) {
                        $s += $this->QR[$i][$k] * $this->QR[$i][$j];
                    }
                    $s = -$s / $this->QR[$k][$k];
                    for ($i = $k; $i < $this->m; ++$i) {
                        $this->QR[$i][$j] += $s * $this->QR[$i][$k];
                    }
                }
            }
            $this->Rdiag[$k] = -$nrm;
        }
    }
}
