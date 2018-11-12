<?php

require('manageCSV.php');
if ($argc > 1) {
    $filename = $argv[1].'.csv';
} else {
    echo "Please provide the csv file name";
    exit();
}
$csv = new manageCSV($filename, 'w'); 

$array[] = ['Month', 'Salary Date', 'Bonus Date'];
for($i = 0; $i < 12; $i++) {
    $add = $i + 1;
    $next = date("Y-m-d", strtotime("+ $add month"));
    $salaryDate = findSalaryDay(date("Y-m-t", strtotime($next)));
    $bonusDate = findBonusDay(date("Y-m-15", strtotime("+1 month", strtotime($next))));
    $month = date("M", strtotime($next));
    $array[] = [$month, $salaryDate, $bonusDate];
}

$csv->write($array);
$csv->export();
$csv->close();

function findSalaryDay($date)
{
    $paymentDate = $date;
    if(date('l', strtotime($date)) == 'Saturday') {
        $paymentDate = date('Y-m-d', strtotime("-1 days", strtotime($date)));
    } else if(date('l', strtotime($date)) == 'Sunday') {
        $paymentDate = date('Y-m-d', strtotime("-2 days", strtotime($date)));
    }
    return $paymentDate;
}

function findBonusDay($date)
{
    $paymentDate = $date;
    if(date('l', strtotime($date)) == 'Saturday' || date('l', strtotime($date)) == 'Sunday') {
        $paymentDate = date('Y-m-d', strtotime("wednesday", strtotime($date)));
    }
    return $paymentDate;
}