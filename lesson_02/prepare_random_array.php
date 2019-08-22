<?php

function getRandomNumber()
{
    return rand(0, 99);
}

function getRandomArray($length)
{
    $arr = [];
    for ($i=0; $i < $length; $i++) { 
        $arr[] = getRandomNumber();
    }
    return $arr;
}