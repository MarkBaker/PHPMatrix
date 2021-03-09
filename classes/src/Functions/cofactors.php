<?php

/**
 *
 * Function code for the matrix cofactors() function
 *
 * @copyright  Copyright (c) 2018 Mark Baker (https://github.com/MarkBaker/PHPMatrix)
 * @license    https://opensource.org/licenses/MIT    MIT
 */

namespace Matrix;

if (!function_exists('Matrix\cofactors')) {
    /**
     * Returns the cofactors of a matrix or an array.
     *
     * @param Matrix|array $matrix Matrix or an array to treat as a matrix.
     * @return Matrix The new matrix
     * @throws Exception If argument isn't a valid matrix or array.
     */
    function cofactors($matrix): Matrix
    {
        if (is_array($matrix)) {
            $matrix = new Matrix($matrix);
        }
        if (!$matrix instanceof Matrix) {
            throw new Exception('Must be Matrix or array');
        }

        return Functions::cofactors($matrix);
    }
}
