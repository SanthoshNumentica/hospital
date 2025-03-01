<?php
function changeDateFormat($dateCol, $data, $format = 'd-m-Y')
{
    foreach ($dateCol as $k => $v) {
        if (checkValue($data, $v)) {
            $data[$v] = date($format, strtotime($data[$v]));
        }
    }
    return $data;
}

function isPastDate($date)
{
    return time() > strtotime($date);

}
function isValidDate($dates)
{
    return date('Y-m-d', strtotime($dates)) === $dates;
}

function checkInBeweenDate($fromD, $todate, $checkDate = null)
{
    $currentDate = date('Y-m-d', strtotime($checkDate ? $checkDate : date('Y-m-d')));
    $startDate   = date('Y-m-d', strtotime($fromD));
    $endDate     = date('Y-m-d', strtotime($todate));
    return ($currentDate >= $startDate) && ($currentDate <= $endDate);
}

function startAndEndMonthByDate($date)
{
    $std       = strtotime($date);
    $month     = date('m', $std);
    $year      = date('Y', $std);
    $dateText  = strtotime('01-' . $month . '-' . $year);
    $startDate = date('d-m-Y', $dateText);
    $endDate   = date('t-m-Y', $dateText);
    return [$month,$year,$startDate,$endDate,$dateText];
}
