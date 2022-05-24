<?php 

use PHPUnit\Framework\TestCase;
use function GenDiff\genDiff;


class GenDiffTest extends TestCase
{
    protected function getFixtureFile(string $format, string $type, string $fileName): string
    {
        $dirs = [__DIR__, 'fixtures', $format, $type, $fileName];

        return implode(DIRECTORY_SEPARATOR, $dirs);
    }

    /**
     * @dataProvider filesProvider
     */
    public function testGenDiff(string $file1, string $file2, string $expectedFile): void
    {
        $this->assertEquals(file_get_contents($expectedFile), genDiff($file1, $file2));
    }

    public function filesProvider(): array
    {
        return [
            [
                $this->getFixtureFile('json', 'simple', 'file1.json'), 
                $this->getFixtureFile('json', 'simple', 'file2.json'),
                $this->getFixtureFile('json', 'simple', 'result.txt')
            ],
            [
                $this->getFixtureFile('yaml', 'simple', 'file1.yml'), 
                $this->getFixtureFile('yaml', 'simple', 'file2.yml'),
                $this->getFixtureFile('yaml', 'simple', 'result.txt')
            ],
            [
                $this->getFixtureFile('json', 'recursive', 'file1.json'), 
                $this->getFixtureFile('json', 'recursive', 'file2.json'),
                $this->getFixtureFile('json', 'recursive', 'result.txt')
            ],
            [
                $this->getFixtureFile('yaml', 'recursive', 'file1.yml'), 
                $this->getFixtureFile('yaml', 'recursive', 'file2.yml'),
                $this->getFixtureFile('yaml', 'recursive', 'result.txt')
            ]
        ];
    }
}