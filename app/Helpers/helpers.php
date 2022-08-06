<?php
namespace App\Helpers;

class UserHelper
{
    public static function getamountbifurcation($amount,$percentage)
    {
    	$datareturn = [];
    	$datareturn['capital_amount'] = $amount;
    	$datareturn['percentile_amount'] = ($percentage / 100) * $amount;
    	$datareturn['percent_deducted_amount'] = floatval($amount) - floatval($datareturn['percentile_amount']);
        return json_decode(json_encode($datareturn));
    }
}