<?php

putenv('GDFONTPATH='. realpath('.'));
$font = 'helvetica';
$resultdiv = "";
$lcars = rand(12, 50)."-".rand(111111, 999999);
$gender = "female";
$cat = "";
$result = 0;
$main_all = "main";
$flipurl = "";
$flipurl2 = "";
$tosactive = "";
$tngactive = "";
$ds9active = "";
$voyactive = "";
$entactive = "";
$allactive = "";

$button_1 = "TOS";
$button_2 = "TNG";
$button_3 = "DS9";
$button_4 = "VOY";
$button_5 = "ENT";
$button_6 = "ALL";

$startdialogue = "<h1>Star Trek - Who's Your Favorite Character?</h1><p>\n
Welcome!<p> What began as a lively debate during a Star Trek marathon with a friend evolved into this interactive project.\n
Here, we celebrate not just the allure but the overall appeal of our favorite Star Trek characters.<p> \n
Dive into our categories (we've included only the best of Star Trek!) and find yourself facing a choice between two characters from the\n
selected series. Votes are categorized by both gender and series to offer nuanced insights.<p>\n
For a broader perspective, check out the 'ALL' section. Here, votes are still separated by gender but encompass characters from across all major\n
Star Trek series.<p>\n
Join the fun and help us determine the most beloved character in the Star Trek universe!\n";

$gender_mask = array(
    "female" => 0,
    "male" => 1,
    "unisex" => 2
);
$series_mask = array(
    "tos" => 0,
    "tng" => 1,
    "ds9" => 2,
    "voy" => 3,
    "ent" => 4
);

function makeurl($category, $gender, $main_all, $result)
{
    $r = "";
    if ($result == 1)
        $r = "&results=1";
    return "index.php?cat=".$category."&gender=".$gender."&main_all=".$main_all.$r;
}

function flipgender($category, $gender, $main_all, $result)
{
    $g = "male";
    if ($gender == "male")
    {
        $g = "female";
    }
    else if ($gender == "female")
    {
        $g = "unisex";
    }
    else
    {
        $g = "male";
    }
    return makeurl($category, $g, $main_all, $result);
}

function flipmain_all($category, $gender, $main_all, $result)
{
    $m = "all";
    if ($main_all == "all")
    {
        $m = "main";
    }
    return makeurl($category, $gender, $m, $result);
}

function init($get)
{
    global $flipurl, $flipurl2, $url_1, $url_2, $url_3, $url_4, $url_5, $url_6, $main_all, $gender, $result, $cat, $tosactive, $tngactive, $ds9active, $voyactive, $entactive, $allactive, $resultdiv;


    if (isset($get['main_all']))
    {
        $main_all = $get['main_all'];
    }
    if (isset($get['gender']))
    {
        $gender = $get['gender'];
    }
    if (isset($get['results']))
    {
        $result = 1;
    }
    if (isset($get['cat']))
    {
        $cat = $_GET['cat'];
    }
    if ($result == 0)
        $resultdiv =  "<a href='".makeurl($cat, $gender, $main_all, 1)."'><div class='gotoresults'> <img src='text.php?text=RESULTS'></div></a>";
    else
        $resultdiv =  "<a href='".makeurl($cat, $gender, $main_all, 0)."'><div class='gotoresults'> <img src='text.php?text=VOTE'></div></a>";

    $flipurl = flipgender($cat, $gender, $main_all, $result);

    $flipurl2 = flipmain_all($cat, $gender, $main_all, $result);

    if ($cat == "tos")
    {
        $tosactive = "color=black&";
    }
    else if ($cat == "tng")
    {
        $tngactive = "color=black&";
    }
    else if ($cat == "ds9")
    {
        $ds9active = "color=black&";
    }
    else if ($cat == "voy")
    {
        $voyactive = "color=black&";
    }
    else if ($cat == "ent")
    {
        $entactive = "color=black&";
    }
    else if ($cat == "all")
    {
        $allactive = "color=black&";
    }
    else
    {
        $resultdiv = "";
    }
    $url_1 = makeurl("tos", $gender, $main_all, $result);
    $url_2 = makeurl("tng", $gender, $main_all, $result);
    $url_3 = makeurl("ds9", $gender, $main_all, $result);
    $url_4 = makeurl("voy", $gender, $main_all, $result);
    $url_5 = makeurl("ent", $gender, $main_all, $result);
    $url_6 = makeurl("all", $gender, $main_all, $result);
}
?>