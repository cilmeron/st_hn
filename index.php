<?php
$title = "Star Trek - Favorite Character DB";
include "cfg.php";
init($_GET);

include "header.php";

if ($cat != "")
{
    vote($cat, $gender);
}
else
{
    echo $startdialogue;
}

function vote($category, $gender)
{
    global $_POST, $series_mask, $gender_mask, $resultdiv, $main_all, $_GET, $result;
    include "db.php";
    $conn = new mysqli($server, $user, $pw, $db);

    if ($conn->connect_error)
    {
        die("Connection failed:". $conn->connect_error);
    }
    $genderdiff = intval(0);
    $genderfilter = "WHERE gender = ".$gender_mask[$gender];
    if ($gender == "unisex")
    {
        $genderdiff = intval(10);
        $genderfilter = "WHERE 1";
    }
    $exclude = "''";
    $done = "";
    $limit = "LIMIT 2;";
    $chars = array();
    $mainint = 1;
    if ($category == "all")
    {
        $ws = "";
        $local = 0;
    }
    else
    {
        $ws = "AND characters.series = ".$series_mask[$category];
        $local = 1;
    }
    if ($main_all == "main")
    {
        $mf = "AND type=1";
        $mainint=intval(1+$genderdiff);
    }
    else
    {
        $mf = "";
        $mainint=intval(0+$genderdiff);
    }


    if (isset($_GET['results']))
    {

        $sql = "
        SELECT * FROM characters
        LEFT JOIN scores
        ON scores.characters_id=characters.ID
        ".$genderfilter." 
        ".$ws." 
        ".$mf." 
        AND scores.main = ".$mainint." 
        AND scores.local = ".$local." ORDER BY score DESC;";
        $results = $conn->query($sql);

        echo "<table><tr><th>Name</th><th>Image</th><th>Votes</th>";
        while ($row = $results->fetch_assoc())
        {
            $sgender = substr(array_search($row['gender'], $gender_mask), 0, 1);
            echo "<tr>";
            echo "<td style='text-align: center; vertical-align: middle;'>".$row['name']."</td>";
            echo "<td style='text-align: center; vertical-align: middle;'><img class='results' src='img/".array_search($row['series'], $series_mask)."/".$sgender."/".$row['fname']."'></td>";
            echo "<td style='text-align: center; vertical-align: middle;'>".$row['score']."</td>";
            echo "</tr>";
        }
        echo "</table>";

    }
    else
    {
        if(isset($_POST['voted']))
        {
            $mainall = 1;
            $local = 1;
            if ($category == "all")
                $local = 0;
            if ($main_all == "all")
                $mainall = 0;
            $mainall = $mainall+$genderdiff;
            $sql = "INSERT INTO scores (characters_id, score, local, main) VALUES(".$_POST['winnerid'].", 1, ".$local.", ".$mainall.") ON DUPLICATE KEY UPDATE score=score+1;";
            $conn->query($sql);
            $limit = "LIMIT 1;";
            if (isset($_POST['prev']))
            {
                $done = $_POST['prev'];
            }
            $ids = explode(",", $done);
            foreach($ids as $id)
            {
                $exclude .= "'".$id."',";
            }
            $exclude = substr($exclude, 0, -1);
            $winner['ID'] = $_POST['winnerid'];
            $winner['name'] = $_POST['winnername'];
            $winner['fname'] = $_POST['winnerfname'];
            $winner['series'] = $_POST['winnerseries'];
            $winner['gender'] = $_POST['winnergender'];
            $chars[] = $winner;

        }

        $genderselect = "gender = '".$gender_mask[$gender]."'";
        if ($gender == "unisex")
            $genderselect = "1";

        $sql = "SELECT * FROM characters WHERE ".$genderselect." 
        ".$ws."
        ".$mf."
        AND ID NOT IN (".$exclude.") ORDER BY RAND() ".$limit;
        $results = $conn->query($sql);
        $m = 0;
        while ($row = $results->fetch_assoc())
        {
            $m++;
            $done .= ",".$row['ID'];
            $chars[] = $row;
        }
        if ($m == 0)
        {
            echo "Your favorite ".$gender." Star Trek (".strtoupper($category).") character is:<br>\n";
            echo "<center><h4>".htmlspecialchars($winner['name'])."</h4><br>\n";
            echo "<button class=\"btn copy__btn\" onclick=\"copyCaption('http://www.ambarenya.net/result.php?id=".$_POST['winnerid']."&cat=".$category."')\">Share Result</button><br>";
            echo "<img src='img/".array_search($winner['series'], $series_mask)."/".substr(array_search($winner['gender'], $gender_mask), 0, 1)."/".$winner['fname']."'>\n";

        }
        else
        {
            $opponents = $chars;
            echo "<form method='post' action='".makeurl($category, $gender, $main_all, $result)."' id='voteForm'>\n";
            echo "<div class='voting-container'>\n";
            $sm = "";
            foreach($opponents as $opps)
            {
                if ($category == "all")
                {
                    $sm = "(".strtoupper(array_search($opps['series'], $series_mask)).")";
                }
                $sgender = substr(array_search($opps['gender'], $gender_mask), 0, 1);
                echo "<div class='votediv'>".htmlspecialchars($opps['name'])." ".$sm."\n";
                echo "<div class='voteimgdiv' onclick='submitVote(this)' data-character-gender='".$opps['gender']."' data-character-series='".$opps['series']."' data-character-id='".$opps['ID']."' data-character-name='".htmlspecialchars($opps['name'])."' data-character-fname='".$opps['fname']."'>\n";
                echo "<img src='img/".array_search($opps['series'], $series_mask)."/".$sgender."/".$opps['fname']."'></div></div>\n";
            }
            echo "</div>\n";
            echo "<input type='hidden' name='voted' value='1'></input>";
            echo "<input type='hidden' name='prev' value='".$done."'></input>";
            echo "</form>";
        }
    }
}
include "footer.php";
?>
