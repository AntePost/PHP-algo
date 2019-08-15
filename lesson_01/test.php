<?php

function testArrs($size)
{
    $forArr = [];
    $iterArr = [];

    for ($i=0; $i < $size; $i++) { 
        $forArr[] = $i;
        $iterArr[] = $i;
    }

    $start = microtime(true);
    foreach ($forArr as $value) {
        $newValue = $value + 1;
    }
    $stop = microtime(true) - $start;
    $stop = round($stop, 5);
    echo "forArr of size $size took $stop microseconds" . PHP_EOL;

    $obj = new ArrayObject($iterArr);
    $iter = $obj->getIterator();
    $start = microtime(true);
    while($iter->valid()) {
        $newValue = $iter->current() + 1;
        $iter->next();
    }
    $stop = microtime(true) - $start;
    $stop = round($stop, 5);
    echo "iterArr of size $size took $stop microseconds" . PHP_EOL;
}

testArrs(10000);
testArrs(100000);
testArrs(1000000);