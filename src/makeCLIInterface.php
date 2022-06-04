<?php

namespace Differ\Differ;

use Docopt;

function makeCLIInterface()
{
    $doc = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
DOC;

    return Docopt::handle($doc, [ 'version' => '1.0.0' ]);
}
