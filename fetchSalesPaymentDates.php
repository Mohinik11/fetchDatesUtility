<?php

require('ManageCSV.php');
require('PaymentDate.php');
const MONTHS = 12;

if ($argc > 1) {
    $filename = $argv[1];
    if(!preg_match('/^([-\.\w]+)$/', $filename)) {
        echo 'Provided filename has illegal characters.';
        exit();
    }
} else {
    echo "Please provide the csv file name";
    exit();
}

$manageCSV = new CSV\manageCSV($filename, 'w'); 
$paymentDate = new FindDate\PaymentDate($manageCSV);
$paymentDate->findPaymentDates(MONTHS);
echo "$filename.csv file has been successfully downloaded at ". getcwd() ."\n";
