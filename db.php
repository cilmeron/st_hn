<?php
$server = "172.21.1.43";
$db = "st_hn";
$user = "st";
$pw = "sthn";

$conn = new mysqli($server, $user, $pw, $db);
if ($conn->connect_error)
{
    die("Connection failed:". $conn->connect_error);
}

function select($sql, $conn)
{
    $output = array();
    $results = $conn->query($sql);            
    while ($row = $results->fetch_assoc())
    {
        $output[] = $row;
    }
    return $output;
}

?>