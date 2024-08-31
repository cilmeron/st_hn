<?php
$genderdiff = 0;

function get_rounds($int)
{
    $done = 0;
    $c = 0;
    $res = $int;
    while($done != 1)
    {
        $c++;
        $res = intval($res/2);
        if ($res == 1)
        {
            $done = 1;
        }
    }
    return $c;
}

function get_sm($category, $series_mask, $series)
{
    $sm = "";
    if ($category == "all")
    {
        $sm = "(".strtoupper(array_search($series, $series_mask)).")";
    }
    return $sm;
}


function get_image_folder($gender, $gender_mask, $series, $series_mask)
{
    return array_search($series, $series_mask)."/".substr(array_search($gender, $gender_mask), 0, 1);
}

function make_list($chars)
{
    $output = array();
    foreach($chars as $char)
    {
        $output[] = $char['ID'];
    }
    return $output;
}

function get_winner($id)
{
    $sql = "SELECT * FROM characters WHERE ID IN (".$id.");";
    return $sql;
}
function get_vote($chars, $idx, $genderselect, $ws, $mf)
{
    $idx = $idx * 2;
    $chars = json_decode($chars, true);
    $ids = "";
    for ($i = $idx; $i < $idx+2; $i++)
    {
        if (isset($chars[$i]))
            $ids .= $chars[$i].",";
        else 
            return "DONE".$ids;
    }
    $ids = substr($ids, 0, -1);
    $sql = "SELECT * FROM characters WHERE ".$genderselect." ".$ws." ".$mf." AND ID IN (".$ids.");";
    return $sql;
}

function select_gender($gender_mask, $gender)
{
    $genderselect = "gender = '".$gender_mask[$gender]."'";
    if ($gender == "unisex")
        $genderselect = "1";
    return $genderselect;
}

function get_gender_diff($gender)
{
    global $genderdiff;
    $genderdiff = intval(0);
    if ($gender == "unisex")
    {
        $genderdiff = intval(10);
    }
    return $genderdiff;
}

function filter_gender($gender_mask, $gender)
{
    $genderfilter = "WHERE gender = ".$gender_mask[$gender];
    if ($gender == "unisex")
    {
        $genderdiff = intval(10);
    }
    $genderfilter = "WHERE 1";
    return $genderfilter;
}


function get_mainint($genderdiff, $main_all)
{
    $mainint=intval(0+$genderdiff);
    if ($main_all == "main")
        $mainint=intval(1+$genderdiff);
    return $mainint;
}

function get_mainall($main_all)
{
    global $genderdiff;
    $mainall = 1;  
    if ($main_all == "all")
        $mainall = 0;
    $mainall = $mainall+$genderdiff;
    return $mainall;
}
function get_ws($category, $series_mask)
{
    $ws = "AND characters.series = ".$series_mask[$category];
    if ($category == "all")
        $ws = "";
    return $ws;
}

function get_local($category)
{
    $local = 1;
    if ($category == "all")
        $local = 0;
    return $local;
}

function get_mf($main_all)
{
    $mf = "";
    if ($main_all == "main")
        $mf = "AND type=1";
    return $mf;
}

?>