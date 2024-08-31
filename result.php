<?php
include "cfg.php";
init($_GET);
$title = "My favorite Star Trek character - RESULT";
include "db.php";
include "header2.php";
if (!isset($_GET['id']))
{
    echo "Something went wrong;";
}
$conn = new mysqli($server, $user, $pw, $db);

if ($conn->connect_error)
{
    die("Connection failed:". $conn->connect_error);
}
$sql = "SELECT * FROM characters WHERE ID='".$conn->real_escape_string($_GET['id'])."';";
$results = $conn->query($sql);
while($row = $results->fetch_assoc())
{
    echo "<center>Your favorite ".array_search($row['gender'], $gender_mask)." Star Trek character (".strtoupper($_GET['cat']).") is:<br>\n";
    echo "<h3>".$row['name']." (".strtoupper(array_search($row['series'], $series_mask)).")</h3><br>";
    echo "<img src='img/".array_search($row['series'], $series_mask).
    "/".substr(array_search($row['gender'], $gender_mask), 0, 1).
    "/".$row['fname']."'>\n";
}
include "footer2.php";
?>