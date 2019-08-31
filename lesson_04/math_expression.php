<?php

// Демонстрация
$expressions = ['3 + 9 * 2', '3 * 9 + 2', '(3 + 9) * 2', '3 * (9 + 2)', '17 + 4 * (5 / 2)'];
foreach ($expressions as $expression) {
    echo $expression . ' = ' . evaluate(convertToPostfix(tokenize($expression))) . '<br>';
}

// Преобразование строки с выражением в массив
function tokenize($expression)
{
    $expressionArr = explode(' ', $expression);
    $outputArr = [];

    foreach ($expressionArr as $expressionEl) {
        if (preg_match('/^\(/', $expressionEl)) {
            $parenthesis = substr($expressionEl, 0, 1);
            $number = substr($expressionEl, 1);
            $outputArr[] = $parenthesis;
            $outputArr[] = $number;
        } elseif (preg_match('/\)$/', $expressionEl)) {
            $number = substr($expressionEl, 0, -1);
            $parenthesis = substr($expressionEl, -1, 1);
            $outputArr[] = $number;
            $outputArr[] = $parenthesis;
        } else {
            $outputArr[] = $expressionEl;
        }
    }
    
    for ($i=0; $i < count($expressionArr); $i++) { 
        
    }

    return $outputArr;
}

// Конвертация массива в обратную польскую нотацию
function convertToPostfix($expressionArr)
{
    $postfixArr = [];
    $stack = new SplStack();

    foreach ($expressionArr as $expressionEl) {
        if (preg_match('/\d/', $expressionEl)) {
            $postfixArr[] = $expressionEl;
        } elseif ($stack->isEmpty()) {
            $stack->push($expressionEl);
        } elseif ($expressionEl === '(') {
            $stack->push($expressionEl);
        } elseif ($expressionEl === ')') {
            while(!$stack->isEmpty() && $stack->top() !== '(') {
                $postfixArr[] = $stack->pop();
            }
            $stack->pop();
        } elseif (checkPrecedence($stack->top(), $expressionEl)) {
            $stack->push($expressionEl);
        } elseif (!checkPrecedence($stack->top(), $expressionEl)) {
            while(!$stack->isEmpty() && checkPrecedence($expressionEl, $stack->top())) {
                $postfixArr[] = $stack->pop();
            }
            $stack->push($expressionEl);
        }
    }

    while (!$stack->isEmpty()) {
        $postfixArr[] = $stack->pop();
    }
    
    return $postfixArr;
}

// Вычисление выражения
function evaluate($postfixArr)
{
    $stack = new SplStack();

    foreach ($postfixArr as $expressionEl) {
        if (preg_match('/\d/', $expressionEl)) {
            $stack->push($expressionEl);
        } else {
            $secondOperand = $stack->pop();
            $firstOperand = $stack->pop();
            $result = arithOper($firstOperand, $secondOperand, $expressionEl);
            $stack->push($result);
        }
    }

    return $stack->pop();
}

// Проверка прецедента операторов
function checkPrecedence($firstOperator, $secondOperator)
{
    if (($firstOperator === '+' || $firstOperator === '-') && ($secondOperator === '*' || $secondOperator === '/')) {
        return true;
    } else {
        return false;
    }
}

// Здесь и далее функции для арифметических операций
function arithOper($term1, $term2, $operation)
{
    switch ($operation) {
        case '+':
            return addition($term1, $term2);
            break;
        case '-':
            return subtraction($term1, $term2);
            break;
        case '*':
            return multiplication($term1, $term2);
            break;
        case '/':
            return division($term1, $term2);
            break;
        default:
            echo 'Not a valid operation';
            break;
    }
}

function addition($addent1, $addent2)
{
    if (!is_numeric($addent1) or !is_numeric($addent2)) {
        echo 'Not a valid input';
        return;
    }
    return $addent1 + $addent2;
}
  
function subtraction($minuend, $subtrahend)
{
    if (!is_numeric($minuend) or !is_numeric($subtrahend)) {
        echo 'Not a valid input';
        return;
    }
    return $minuend - $subtrahend;
}
  
function multiplication($factor1, $factor2)
{
    if (!is_numeric($factor1) or !is_numeric($factor2)) {
        echo 'Not a valid input';
        return;
    }
    return $factor1 * $factor2;
}
  
function division($dividend, $divisor)
{
    if (!is_numeric($dividend) or !is_numeric($divisor)) {
        echo 'Not a valid input';
        return;
    }
    if ($divisor === 0) {
        echo 'Attempt to divide by zero';
        return;
    }
    return $dividend / $divisor;
}