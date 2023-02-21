<?php

function d($var, ?string $varname = null): void
{
    echo '<pre class="dumper" style="margin:30px 0 40px">';
    echo $varname ? '<strong style="padding: 10px 16px; text-transform: uppercase;font-size: 16px; background: #c3ec94; display: inline-block; border-top: 1px dashed #808080;border-bottom: 1px dashed #808080;margin-bottom: 14px">' . $varname . '</strong><br>' : null;
    $sep = '';

    if (is_object($var)) {
        $class = get_class($var);
        $strlen = strlen("Instance of : " . $class);
        for ($i = 0; $i < $strlen; ++$i) {
            $sep .= '-';
        }
        echo '<em>Instance of : ' . $class . '</em><br>' . $sep .'<br>';
        method_exists($class, 'toArray') ? print_r($var->toArray()) : print_r($var);
    }
    elseif (is_string($var)) {
        var_dump($var);
    }
     else {
            is_array($var) ? print_r($var) : var_dump($var);
    }
    echo '</pre>';
}

function de($var, $varname = null): void
{
    d($var, $varname);
    exit;
}
