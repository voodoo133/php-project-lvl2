<?php 

use PHPUnit\Framework\TestCase;
use function GenDiff\genDiff;


class GenDiffTest extends TestCase
{
    protected $pathToJSONFixtures = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'json';
    protected $pathToYAMLFixtures = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'yaml';

    public function testGenDiffJsonSimple()
    {
        $pathTofile1 = $this->pathToJSONFixtures . DIRECTORY_SEPARATOR . 'simple' . DIRECTORY_SEPARATOR . 'file1.json';
        $pathTofile2 = $this->pathToJSONFixtures . DIRECTORY_SEPARATOR . 'simple' . DIRECTORY_SEPARATOR . 'file2.json';

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

    public function testGenDiffYamlSimple()
    {
        $pathTofile1 = $this->pathToYAMLFixtures . DIRECTORY_SEPARATOR . 'simple' . DIRECTORY_SEPARATOR . 'file1.yml';
        $pathTofile2 = $this->pathToYAMLFixtures . DIRECTORY_SEPARATOR . 'simple' . DIRECTORY_SEPARATOR . 'file2.yml';

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

    public function testGenDiffJsonRecursive()
    {
        $pathTofile1 = $this->pathToJSONFixtures . DIRECTORY_SEPARATOR . 'recursive' . DIRECTORY_SEPARATOR . 'file1.json';
        $pathTofile2 = $this->pathToJSONFixtures . DIRECTORY_SEPARATOR . 'recursive' . DIRECTORY_SEPARATOR . 'file2.json';

        $resultStrings = [
            "{",
            "    common: {",
            "      + follow: false",
            "        setting1: Value 1",
            "      - setting2: 200",
            "      - setting3: true",
            "      + setting3: null",
            "      + setting4: blah blah",
            "      + setting5: {",
            "            key5: value5",
            "        }",
            "        setting6: {",
            "            doge: {",
            "              - wow:",
            "              + wow: so much",
            "            }",
            "            key: value",
            "          + ops: vops",
            "        }",
            "    }",
            "    group1: {",
            "      - baz: bas",
            "      + baz: bars",
            "        foo: bar",
            "      - nest: {",
            "            key: value",
            "        }",
            "      + nest: str",
            "    }",
            "  - group2: {",
            "        abc: 12345",
            "        deep: {",
            "            id: 45",
            "        }",
            "    }",
            "  + group3: {",
            "        deep: {",
            "            id: {",
            "                number: 45",
            "            }",
            "        }",
            "        fee: 100500",
            "    }",
            "}"
        ];

        $result = join("\n", $resultStrings) . "\n";

        $this->assertEquals($result, genDiff($pathTofile1, $pathTofile2));
    }

    public function testGenDiffYamlRecursive()
    {
        $pathTofile1 = $this->pathToYAMLFixtures . DIRECTORY_SEPARATOR . 'recursive' . DIRECTORY_SEPARATOR . 'file1.yml';
        $pathTofile2 = $this->pathToYAMLFixtures . DIRECTORY_SEPARATOR . 'recursive' . DIRECTORY_SEPARATOR . 'file2.yml';

        $resultStrings = [
            "{",
            "    common: {",
            "      + follow: false",
            "        setting1: Value 1",
            "      - setting2: 200",
            "      - setting3: true",
            "      + setting3: null",
            "      + setting4: blah blah",
            "      + setting5: {",
            "            key5: value5",
            "        }",
            "        setting6: {",
            "            doge: {",
            "              - wow:",
            "              + wow: so much",
            "            }",
            "            key: value",
            "          + ops: vops",
            "        }",
            "    }",
            "    group1: {",
            "      - baz: bas",
            "      + baz: bars",
            "        foo: bar",
            "      - nest: {",
            "            key: value",
            "        }",
            "      + nest: str",
            "    }",
            "  - group2: {",
            "        abc: 12345",
            "        deep: {",
            "            id: 45",
            "        }",
            "    }",
            "  + group3: {",
            "        deep: {",
            "            id: {",
            "                number: 45",
            "            }",
            "        }",
            "        fee: 100500",
            "    }",
            "}"
        ];

        $result = join("\n", $resultStrings) . "\n";

        $this->assertEquals($result, genDiff($pathTofile1, $pathTofile2));
    }
}