<?php 

use PHPUnit\Framework\TestCase;
use function Gendiff\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiff()
    {
        $pathTofile1 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'file1.json';
        $pathTofile2 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'file2.json';

        $resultStrings = [
            "{",
            "  - follow: false",
            "    host: hexlet.io",
            "  - proxy: 123.234.53.22",
            "  - timeout: 50",
            "  + timeout: 20",
            "  + verbose: true",
            "}"
        ];

        $result = join("\n", $resultStrings) . "\n";

        $this->assertEquals($result, genDiff($pathTofile1, $pathTofile2));
    }
}