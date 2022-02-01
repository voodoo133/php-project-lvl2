<?php 

use PHPUnit\Framework\TestCase;
use function GenDiff\genDiff;


class GenDiffTest extends TestCase
{
    public function testGenDiffJson()
    {
        $pathTofile1 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . '/json/file1.json';
        $pathTofile2 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . '/json/file2.json';

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

    public function testGenDiffYaml()
    {
        $pathTofile1 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . '/yaml/file1.yml';
        $pathTofile2 = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . '/yaml/file2.yml';

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