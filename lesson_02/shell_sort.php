<?php

include './prepare_random_array.php';

function shellSort($arr)
{
    $k = 0; // O(1);
    $length = count($arr); // O(1);
    $gap[0] = (int) ($length / 2); // O(1);

    while ($gap[$k] > 1) { // O(log(n));
        $k++;
        $gap[$k] = (int) ($gap[$k - 1] / 2);
    }

    for ($i=0; $i <= $k; $i++) { // O(log(n)); Центральная часть алгоритма с точки зрения сложности
        $step = $gap[$i];
        
        for ($j=$step; $j < $length; $j++) { // O(~n);
            $temp = $arr[$j];
            $p = $j - $step;

            while ($p >= 0 && $temp < $arr[$p]) {
                $arr[$p + $step] = $arr[$p];
                $p = $p - $step;
            }

            $arr[$p + $step] = $temp;
        }
    }

    return $arr;  // O(1);

    // Итого: O(1) + O(1) + O(1) + O(log(n)) + O(log(n)) * O(~n) + O(1);
    // Убрав лишнее и оставив только центральную часть: O(log(n)) * O(~n);
    // Итого: O(n log(n));
}

$arr = getRandomArray(100);
var_dump(shellSort($arr));