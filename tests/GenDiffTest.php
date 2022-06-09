<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    protected function getFixtureFile(...$pathParams): string
    {
        $filePathParams = [__DIR__, 'fixtures', ...$pathParams];

        return implode(DIRECTORY_SEPARATOR, $filePathParams);
    }

    /**
     * @dataProvider filesProvider
     */
    public function testGenDiff(string $file1, string $file2, string $format, string $expectedFile): void
    {
        $this->assertEquals(file_get_contents($expectedFile), genDiff($file1, $file2, $format));
    }

    public function filesProvider(): array
    {
        return [
            [
                $this->getFixtureFile('json', 'file1.json'),
                $this->getFixtureFile('json', 'file2.json'),
                'stylish',
                $this->getFixtureFile('result', 'stylish.txt')
            ],
            [
                $this->getFixtureFile('yaml', 'file1.yml'),
                $this->getFixtureFile('yaml', 'file2.yml'),
                'stylish',
                $this->getFixtureFile('result', 'stylish.txt')
            ],
            [
                $this->getFixtureFile('json', 'file1.json'),
                $this->getFixtureFile('json', 'file2.json'),
                'plain',
                $this->getFixtureFile('result', 'plain.txt')
            ],
            [
                $this->getFixtureFile('yaml', 'file1.yml'),
                $this->getFixtureFile('yaml', 'file2.yml'),
                'plain',
                $this->getFixtureFile('result', 'plain.txt')
            ],
            [
                $this->getFixtureFile('json', 'file1.json'),
                $this->getFixtureFile('json', 'file2.json'),
                'json',
                $this->getFixtureFile('result', 'json.txt')
            ],
            [
                $this->getFixtureFile('yaml', 'file1.yml'),
                $this->getFixtureFile('yaml', 'file2.yml'),
                'json',
                $this->getFixtureFile('result', 'json.txt')
            ]
        ];
    }
}
