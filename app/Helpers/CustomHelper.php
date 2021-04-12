<?php
if ( ! function_exists('getDateInterval')) {
    function getDateInterval($dayInterval) {
        $lastDate = date("Y-m-d");
        $firstDate = date('Y-m-d', strtotime($lastDate.' - '.$dayInterval.' days'));
        return (object) [
            "lastDate" => $lastDate,
            "firstDate" => $firstDate
        ];
    }
}
