<?php

require('ManageCSV.php');
require('PaymentDate.php');

if ($argc > 1) {
    $filename = $argv[1];
} else {
    echo "Please provide the csv file name";
    exit();
}

$manageCSV = new CSV\manageCSV($filename, 'w'); 
$paymentDate = new FindDate\PaymentDate($manageCSV);
$paymentDate->findPaymentDates($filename);
