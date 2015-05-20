<?php

//Fix for travis if wp function not exist

if (!function_exists('did_action')) {
    function did_action($tag)
    {
        //
    }
}

if (!function_exists('add_action')) {
    function add_action($hook, $function_to_add, $priority, $accepted_args)
    {
        //
    }
}