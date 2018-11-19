<?php

namespace FindDate;

use FindDate\ManageCSV;

/**
 * PaymentDate
 * 
 * calculate future payment dates
 *
 */
class PaymentDate {

    /**
     * csv
     * @var object ManageCSV
     */
    private $csv;

    /**
     * data
     * @var array data containing dates
     */
    private $data;

    /**
     * Class constructor
     * @param object ManageCSV
     */
    public function __construct(ManageCSV $manageCSV)
    {
        $this->csv = $manageCSV;
        $this->data = [['Month', 'Salary Payment Date', 'Bonus Payment Date']];
    }

    /**
     * find future payment dates for 12 months
     * writes data to csv file
     * exports file
     * @param integer $months
     */
    public function exportPaymentDates($months = 12)
    {
        $this->calculatePaymentDates($months);
        if(!$this->csv->write($this->data)) {
            return 'Error in writing file';
        }
        if(!$this->csv->export()) {
            return 'Error in downloading file';
        }
        if(!$this->csv->close()) {
            return 'Error in closing file';
        }
        return true;
    }

    /**
    * calculates salary and bonus payment dates 
    * @param integer $months
    */
    private function calculatePaymentDates($months)
    {
        for($i = 0; $i < $months; $i++) {
            $add = $i + 1;
            $next = date("Y-m-d", strtotime("+ $add month"));
            $salaryDate = $this->findSalaryDay(date("Y-m-t", strtotime($next)));
            $bonusDate = $this->findBonusDay(date("Y-m-15", strtotime("+1 month", strtotime($next))));
            $month = date("M, Y", strtotime($next));
            $this->data[] = [$month, $salaryDate, $bonusDate];
        }
    }

    /**
    * adjust salary date in case of weekend
    * @param datetime $date
    */
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

    /**
    * adjust bonus date in case of weekend
    * @param datetime $date
    */
    private function findBonusDay($date)
    {
        $paymentDate = $date;
        if(date('l', strtotime($date)) == 'Saturday' || date('l', strtotime($date)) == 'Sunday') {
           $paymentDate = date('Y-m-d', strtotime("wednesday", strtotime($date)));
        }
        return $paymentDate;
    }

}