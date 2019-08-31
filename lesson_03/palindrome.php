<?php

$words = ['level', 'lever', 'redder', 'four'];

function palindrome($word)
{
    if (strlen($word) <= 1) {
        return true;
    }

    if ($word[0] === $word[strlen($word) - 1]) {
        return palindrome(substr($word, 1, -1));
    } else {
        return false;
    }
}

foreach ($words as $word) {
    var_dump(palindrome($word));
}