<?php

include './prepare_random_array.php';

function mergeSort($arr)
{
    $length = count($arr);
    if ($length === 1) return $arr;

    $mid = $length / 2;
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    $left = mergeSort($left);
    $right = mergeSort($right);

    $result = [];

    while (count($left) > 0 && count($right) > 0) {
        if ($left[0] < $right[0]) {
            $result[] = $left[0];
            $left = array_slice($left, 1);
        } else {
            $result[] = $right[0];
            $right = array_slice($right, 1);
        }
    }

    while (count($left) > 0) {
        $result[] = $left[0];
        $left = array_slice($left, 1);
    }

    while (count($right) > 0) {
        $result[] = $right[0];
        $right = array_slice($right, 1);
    }

    return $result;
}

$arr = getRandomArray(100);
var_dump(mergeSort($arr));