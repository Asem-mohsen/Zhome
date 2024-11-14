<?php

if (! function_exists('ensureArray')) {
    function ensureArray($input)
    {
        if (is_null($input)) {
            return [];
        }

        return is_array($input) ? $input : [$input];
    }
}
