<?php

namespace Matrix\Test;

use Matrix\Builder;

class BuilderTest extends BaseTestAbstract
{
    public function testCreateFilledMatrix()
    {
        $matrix = Builder::createFilledMatrix(7, 7);
        $this->assertIsMatrixObject($matrix);
    }

    public function testCreateIdentityMatrix()
    {
        $matrix = Builder::createIdentityMatrix(3);
        $this->assertIsMatrixObject($matrix);
    }
}
