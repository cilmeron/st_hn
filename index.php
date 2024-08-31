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
    include "functions.php";

    $genderselect = select_gender($gender_mask, $gender);
    $genderdiff = get_gender_diff($gender);
    $genderfilter = filter_gender($gender_mask, $gender);
    $end = 0;
    $chars = array();
    $mainint = get_mainint($genderdiff, $main_all);
    $ws = get_ws($category, $series_mask);
    $local = get_local($category);
    $mf = get_mf($main_all);
    $mainall = get_mainall($main_all);
    
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
            $sql = "INSERT INTO scores (characters_id, score, local, main) VALUES(".$_POST['winnerid'].", 1, ".$local.", ".$mainall.") ON DUPLICATE KEY UPDATE score=score+1;";
            $conn->query($sql);
            $list = $_POST['list'];
            $idx = $_POST['idx'];
            $sql = get_vote($_POST['list'], $idx, $genderselect, $ws, $mf);
            if (strlen($_POST['list2']) > 1)
                $list2 = $_POST['list2'].",".$_POST['winnerid'];
            else
                $list2 = $_POST['winnerid'];
            
            if(count(json_decode($list, true)) == 2)
            {
                $end = 1;
                $winner = select(get_winner($_POST['winnerid']), $conn)[0];
                $imagefolder = get_image_folder($winner['gender'], $gender_mask, $winner['series'], $series_mask);
                echo "Your favorite ".$gender." Star Trek (".strtoupper($category).") character is:<br>\n";
                echo "<center><h4>".$winner['name']."</h4><br>\n";
                echo "<button class=\"btn copy__btn\" onclick=\"copyCaption('http://www.ambarenya.net/result.php?id=".$_POST['winnerid']."&cat=".$category."')\">Share Result</button><br>";
                echo "<img src='img/".$imagefolder."/".$winner['fname']."'>\n";
            }
            else
            {
                if (strpos($sql, "DONE") !== FALSE)
                {
                    $remid = intval(explode("DONE", $sql)[1]);
                    if ($remid > 1)
                        $list2 = $remid.",".$list2;
                    $n = explode(",", $list2);
                    $list = json_encode($n);
                    $list2 = "";
                    $idx = 0;
                    $sql = get_vote($list, $idx, $genderselect, $ws, $mf);
                    $vote = select($sql, $conn);
                }
                else
                {
                    $vote = select($sql, $conn);
                }
            }
        }
        else
        {
            $sql = "SELECT * FROM characters WHERE ".$genderselect." ".$ws." ".$mf." ORDER BY RAND()";
            $chars = select($sql, $conn);
            $rounds = get_rounds(count($chars));
            $list = json_encode(make_list($chars));
            $list2 = "";
            $sql = get_vote($list, 0, $genderselect, $ws, $mf);
            $vote = select($sql, $conn);
            $idx = 0;
        }
        if ($end != 1)
        {
            echo "<form method='post' action='".makeurl($category, $gender, $main_all, $result)."' id='voteForm'>\n";
            echo "<div class='voting-container'>\n";
            echo "<input type='hidden' name='list' value='".$list."'></input>";
            echo "<input type='hidden' name='list2' value='".$list2."'></input>";
            echo "<input type='hidden' name='idx' value='".intval($idx+1)."'></input>";
            foreach($vote as $v)
            {
                $sm = get_sm($category, $series_mask, $v['series']);
                $imagefolder = get_image_folder($v['gender'], $gender_mask, $v['series'], $series_mask);              
                echo "<div class='votediv'>".htmlspecialchars($v['name'])." ".$sm."\n";
                echo "<div class='voteimgdiv' onclick='submitVote(this)' data-character-id='".$v['ID']."'>\n";
                echo "<img src='img/".$imagefolder."/".$v['fname']."'></div></div>\n";
            }
            
            echo "</div>\n";
            echo "<input type='hidden' name='voted' value='1'></input>";
            echo "</form>";
        }
    }
}
include "footer.php";
?>
