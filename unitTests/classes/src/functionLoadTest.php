<?php

namespace MatrixTest;

class functionLoadTest extends BaseTestAbstract
{
    /**
     * @dataProvider functionFileProvider
     */
    public function testOnlyLoadFunctionOnce(string $filename): void
    {
        include $filename;
        self::assertIsString($filename);
    }

    public function functionFileProvider(): array
    {
        $functionFolderName = realpath(__DIR__ . '/../../../classes/src/Functions');
        $functionFileList = glob($functionFolderName . '/*.php');
        $functionFileList = array_map(function ($filename) { return [$filename];}, $functionFileList);
        return $functionFileList;
    }

    /**
     * @dataProvider operationFileProvider
     */
    public function testOnlyLoadOperationOnce(string $filename): void
    {
        include $filename;
        self::assertIsString($filename);
    }

    public function operationFileProvider(): array
    {
        $functionFolderName = realpath(__DIR__ . '/../../../classes/src/Operations');
        $functionFileList = glob($functionFolderName . '/*.php');
        $functionFileList = array_map(function ($filename) { return [$filename];}, $functionFileList);
        return $functionFileList;
    }
}
