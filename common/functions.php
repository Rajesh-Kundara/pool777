<?php
function getFactorial($number) {
	$value=1;
	for($i=2;$i<=$number;$i++){
		$value=$value*$i;
	}
	return $value;
}
function getTotalLines($totalSelected,$under) {
	return getFactorial($totalSelected)/(getFactorial($totalSelected-$under)*getFactorial($under));
}
function getWinningLines($totalWon,$under) {
	return getFactorial($totalWon)/(getFactorial($totalWon-$under)*getFactorial($under));
}
?>