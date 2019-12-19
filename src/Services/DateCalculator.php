<?php


namespace App\Services;


class DateCalculator
{
    public function yearsDifference($year)
    {
        $currentYear = date('Y');

        $diff = $currentYear - $year;

        return $diff;
    }
}