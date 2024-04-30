<?php

if (!function_exists('dd')) {
    function dd($argument)
    {
        echo "<pre>";
        print_r($argument);
        die();
    }
}

if (!function_exists('randomStr')) {
    function randomStr($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}