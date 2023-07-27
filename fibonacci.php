<?php

function fibonacci($n) {
    $fib = array(0, 1);
    for ($i = 2; $i < $n; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
    }
    return $fib;
}

$input = 5;
echo 'Input: '.$input.', ';
$fibonacciSequence = fibonacci($input);
echo 'Output: '.implode(", ", $fibonacciSequence);

?>