<?php

namespace FindDate;

use CSV\ManageCSV;

class PaymentDate {

	private $csv;

	private $data;

	public function __construct(ManageCSV $manageCSV) 
	{
		$this->csv = $manageCSV;
		$this->data = [['Month', 'Salary Date', 'Bonus Date']];
	}

	public function findPaymentDates()
	{
		for($i = 0; $i < 12; $i++) {
		    $add = $i + 1;
		    $next = date("Y-m-d", strtotime("+ $add month"));
		    $salaryDate = $this->findSalaryDay(date("Y-m-t", strtotime($next)));
		    $bonusDate = $this->findBonusDay(date("Y-m-15", strtotime("+1 month", strtotime($next))));
		    $month = date("M", strtotime($next));
		    $this->data[] = [$month, $salaryDate, $bonusDate];
		}

		$this->csv->write($this->data);
		$this->csv->export();
		$this->csv->close();
	}

	private function findSalaryDay($date)
	{
	    $paymentDate = $date;
	    if(date('l', strtotime($date)) == 'Saturday') {
	        $paymentDate = date('Y-m-d', strtotime("-1 days", strtotime($date)));
	    } else if(date('l', strtotime($date)) == 'Sunday') {
	        $paymentDate = date('Y-m-d', strtotime("-2 days", strtotime($date)));
	    }
	    return $paymentDate;
	}

	private function findBonusDay($date)
	{
	    $paymentDate = $date;
	    if(date('l', strtotime($date)) == 'Saturday' || date('l', strtotime($date)) == 'Sunday') {
	        $paymentDate = date('Y-m-d', strtotime("wednesday", strtotime($date)));
	    }
	    return $paymentDate;
	}

}