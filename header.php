<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/share.css">
<script src='js/vote.js'></script>
<script src='js/share.js'></script>
<title><?php echo $title; ?></title>
</head>
<body>
<div class='lcarstop'>
<div class='quartercircle_left'><div class='lcars_text_1'><a class='navlink' href='index.php'><?php echo $lcars; ?></a></div></div>
<div class='line_1b'></div>
<div class='innerquartercircle_left'></div>
<div class='line_1'></div>
<div class='line_2'></div>
<div class='line_3'></div>
<div class='line_4'></div>
<div class='line_5'></div>
<a href='<?php echo $url_1; ?>'>
    <div class='b_1 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $tosactive;?>text=<?php echo $button_1; ?>">
    </div>
</a>
<a href='<?php echo $url_2; ?>'>
    <div class='b_2 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $tngactive;?>text=<?php echo $button_2; ?>">
    </div>
</a>
<a href='<?php echo $url_3; ?>'>
    <div class='b_3 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $ds9active;?>text=<?php echo $button_3; ?>">
    </div>
</a>
<a href='<?php echo $url_4; ?>'>
    <div class='b_4 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $voyactive;?>text=<?php echo $button_4; ?>">
    </div>
</a>
<a href='<?php echo $url_5; ?>'>
    <div class='b_5 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $entactive;?>text=<?php echo $button_5; ?>">
    </div>
</a>
<a href='<?php echo $url_6; ?>'>
    <div class='b_6 b_img'>
        <div class='b_text'></div>
        <img src="text.php?<?php echo $allactive;?>text=<?php echo $button_6; ?>">
    </div>
</a>
<div class='bottom_remainder'></div>
</div>
<?php echo $resultdiv; ?>
<div class='main'>