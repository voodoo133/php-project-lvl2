<?php

namespace Differ\Differ\Formatters\Json;

function format(array $diff)
{
    return json_encode($diff);
}
