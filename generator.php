<?php

$lastDigit = $_GET['lastDigit'] ?? null;
$numbers = generateCPF();

if (!empty($lastDigit)){
	while($numbers[10] != $lastDigit){
		$numbers = generateCPF();
	}
}

$num = implode('', $numbers);
echo json_encode(['cpf' => $num]);

function generateCPF(){
	$numbers = array_map(function () {
		return rand(1, 9);
	}, array_fill(0, 9, null));

	$numbers[9] = getDigit($numbers, 1);
	$numbers[10] = getDigit($numbers, 2);

	return $numbers;
}

function getDigit(array $numbers, int $digit): int{
	$multipliers = [10, 9, 8, 7, 6, 5, 4, 3, 2];
	if ($digit == 2) array_unshift($multipliers, 11);

	$resultArr = array_map(function ($number, $multiplier) {
		return $number * $multiplier;
	}, $numbers, $multipliers);

	$sum = array_sum($resultArr);
	$mod = $sum % 11;

	if ($mod >= 2) return 11 - $mod;
	return 0;
}