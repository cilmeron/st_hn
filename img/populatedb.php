<?php
include "../cfg.php";

include "../db.php";
$conn = new mysqli($server, $user, $pw, $db);
if ($conn->connect_error)
{
    die("Connection failed:". $conn->connect_error);
}

$folders = scandir(".");
foreach($folders as $folder)
{
    if ($folder != "." && $folder != ".." && is_dir($folder))
    {
        if (!is_dir($folder."/f"))
        {
            mkdir($folder."/f");
        }
        if (!is_dir($folder."/m"))
        {
            mkdir($folder."/m");
        }
        $female = scandir($folder."/f");
        $male = scandir($folder."/m");
        foreach($female as $f)
        {
            if ($f != "." && $f != "..")
                add_to_db($f, "female", $folder);
        }
        foreach($male as $m)
        {
            if($m != "." && $m != "..")
                add_to_db($m, "male", $folder);
        }
    }
}


function add_to_db($name, $gender, $series)
{
    global $conn;
    global $gender_mask, $series_mask;
    $fname = $name;
    if(substr($name, 0, 2) == "f_")
    {
        $name = substr($name, 2);
    }
    $name = str_replace(".jpg", "", $name);
    $names = explode("_", $name);
    $name = "";
    $num = 0;
    foreach($names as $n)
    {
        if(strpos($n, "+") !== false)
        {
            $pos = strpos($n, "+");
            $name .= strtoupper(substr($n, 0, 1)).substr($n, 1, $pos-1).strtoupper(substr($n, $pos+1, 1)).substr($n, $pos+2)." ";
        }
        else if (strpos($n, "$") !== false)
        {
            $pos = strpos($n, "$");
            $num = substr($n, $pos+1);
            $name .= strtoupper(substr($n, 0, 1)).substr($n, 1, $pos-1)." ";
        }
        else
        {
            $name .= strtoupper(substr($n, 0, 1)).substr($n, 1)." ";
        }
    }
    $name = substr($name, 0, -1);
    if ($num != 0)
    {
        if (intval($num) == 1)
        {
            $affix = "st";
        }
        else if (intval($num) == 2)
        {
            $affix = "nd";
        }
        else if (intval($num) == 3)
        {
            $affix = "rd";
        }
        else if (intval($num) > 3)
        {
            $affix = "th";
        }
        $name .= " (".$num.$affix.")";
    }
    $sql = "INSERT INTO characters
    SET gender='".$gender_mask[$gender]."',
    name='".$name."',
    series='".$series_mask[$series]."',
    fname='".$fname."'
    ON DUPLICATE KEY UPDATE gender=".$gender_mask[$gender].", name='".$name."', series='".$series_mask[$series]."', fname='".$fname."';
    ";
    $conn->query($sql);
}






?>