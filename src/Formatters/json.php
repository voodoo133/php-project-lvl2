<?php

namespace GenDiff\Formatters\Json;

function format($diff)
{
    return json_encode($diff);
}
