<?php
function baseUrl($path = '')
{
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    if ($scriptName === '\\' || $scriptName === '/') {
        $scriptName = '';
    }
    return rtrim($scriptName, '/') . '/' . ltrim($path, '/');
}
