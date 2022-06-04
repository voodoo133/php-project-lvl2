<?php

namespace Differ\Differ\Formatters\Json;

function format($diff)
{
    return json_encode($diff);
}
