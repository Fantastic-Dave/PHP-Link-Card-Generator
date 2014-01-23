<?php
error_reporting(E_ALL ^ E_NOTICE); // ignore errors when noobies type a wrong game pic or whatever :/ pfft noobs
date_default_timezone_set('Europe/London');
$ool = "ID:";
$oorep = "Rep: ";
$orep = "%";
$rImgg = "../images/32images/";
$rImgg2 = "../images/";
$bgdir = "../images/bg/";

if (@getimagesize("../images/online-icon64.png")) {
$onlineicon = imagecreatefrompng("../images/online-icon64.png");
imagesavealpha($onlineicon, false);
imagealphablending($onlineicon, false);
}
if (@getimagesize("../images/offline-icon64.png")) {
$offlineicon = imagecreatefrompng("../images/offline-icon64.png");
imagesavealpha($offlineicon, false);
imagealphablending($offlineicon, false);
}


function imagettftextoutline(&$rImg,$size,$angle,$x,$y,&$col,
            &$outlinecol,$fontfile,$text,$width) {
    // For every X pixel to the left and the right
    for ($xc=$x-abs($width);$xc<=$x+abs($width);$xc++) {
        // For every Y pixel to the top and the bottom
        for ($yc=$y-abs($width);$yc<=$y+abs($width);$yc++) {
            // Draw the text in the outline color
            $text1 = imagettftext($rImg,$size,$angle,$xc,$yc,$outlinecol,$fontfile,$text);
        }
    }
    // Draw the main text
    $text2 = imagettftext($rImg,$size,$angle,$x,$y,$col,$fontfile,$text);
}

if(!isset($_GET['id']))
{ 
$id = "c01eman";
}
else { 
$id = $_GET['id']; }
if(!isset($_GET['fav1'])) { 
$fav1 = "mw2";
}
else { 
$fav1 = stripslashes(strtolower($_GET['fav1']));
}
if(!isset($_GET['fav2']))
{ 
$fav2 = "mw3";
}
else { 
$fav2 = stripslashes(strtolower($_GET['fav2']));
}
if(!isset($_GET['fav3']))
{ 
$fav3 = "codg";
}
else { 
$fav3 = stripslashes(strtolower($_GET['fav3']));
}
if(!isset($_GET['fav4']))
{ 
$fav4 = "bo2";
}
else { 
$fav4 = stripslashes(strtolower($_GET['fav4']));
}
if(!isset($_GET['fav5']))
{ 
$fav5 = "bo1";
}
else { 
$fav5 = stripslashes(strtolower($_GET['fav5']));
}
if(!isset($_GET['fav6']))
{ 
$fav6 = "codwaw";
}
else { 
$fav6 = stripslashes(strtolower($_GET['fav6']));
}
$jpg = ".jpg";
$png = ".png";

/// curl stuff //// gets info from jqe site using json or something
$url="http://link.jqe360.com/Lib/userlist.php?page=1&count=1&search=$id";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$user_agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'; 
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$cJSON = curl_exec($ch);
$feed=json_decode($cJSON, true);
//if ($cJSON == "NULL") {
//} else { 
//header( 'Location: http://linkcard.yzi.me/card.php'.$_SERVER['REQUEST_URI'] ) ;
//}
if(isset($feed[count])) {
$count = $feed[count];
}
/// Get info from downloaded curl shiznit
if(empty($feed["userlist"][0]["GamerTag"]))
{
$gt = "Not signed in";
}
else
{
$gt = $feed["userlist"][0]["GamerTag"];
}

$room = $feed["userlist"][0]["roomname"];
$name = $feed["userlist"][0]["username"];
$rep = $feed["userlist"][0]["Rating"];
$online = $feed["userlist"][0]["online"];
$playing = $feed["userlist"][0]["ParentName"];
// remove the symbols from the game name
$play1 = strtolower(preg_replace( "#[^a-zA-Z0-9 ]#", "", $playing));
// wrap the text
$play2 = wordwrap($playing, 22, "\n", true);
$play3 = explode ("\n", $play2);
$room2 = wordwrap($room, 22, "\n", true);
$room3 = explode ("\n", $room2);
// finished wrapping eh?
// convert the mins to hour and mins
$mins_ago = $feed["userlist"][0]["LastOnline"];
function convertFromMinutes($mins_ago)
{
    $hours = (int)($mins_ago / 60);
    $minutes = $mins_ago - ($hours * 60);
    return array('hours' => $hours, 'minutes' => $minutes);
}
$mins_ago = convertFromMinutes($mins_ago);
$lastonlinehrs = $mins_ago['hours'] . " Hours ";
$lastonlinemins = $mins_ago['minutes'] . " Minutes ago";


if(!isset($_GET['bg'])) { 
if ($online == 1) $background = "blue";
if ($online == 0) $background = "red";
}
else {
if ($online == 1) $background = strtolower(preg_replace( "#[^a-zA-Z0-9 ]#", "", $_GET['bg']));
if(!is_file($bgdir.$background.$jpg)){ 
$background = "errorcard";
}
else {
if ($online == 1) $background = strtolower(preg_replace( "#[^a-zA-Z0-9 ]#", "", $_GET['bg']));
}
}

if(!isset($_GET['bgo'])) { 
if ($online == 0) $background = "red";
}
else {
if ($online == 0) $background = strtolower(preg_replace( "#[^a-zA-Z0-9 ]#", "", $_GET['bgo']));
if(!is_file($bgdir.$background.$jpg)){ 
$background = errorcard;
}
else {
if ($online == 0) $background = strtolower(preg_replace( "#[^a-zA-Z0-9 ]#", "", $_GET['bgo']));
}
}

$rImg = ImageCreateFromJPEG($bgdir.$background.$jpg); // start creating the image using a base image
$white = imagecolorallocate($rImg, 255, 255, 255);
$yellow = imagecolorallocate($rImg, 255, 255, 0);
$purple =  imagecolorallocate($rImg, 89, 3, 255);
$grey = imagecolorallocate($rImg, 128, 128, 128);
$black = imagecolorallocate($rImg, 0, 0, 0);
//$red = imagecolorallocate($rImg, 255, 22, 5);
$width = 230;
$height = 150;
$top_image = imagecreatefrompng("top.png");
imagesavealpha($top_image, false);
imagealphablending($top_image, false);
imagecopy($rImg, $top_image, 0, 0, 0, 0, $width, $height);

if (@getimagesize($rImgg.$fav1.$jpg)) {
$icon1 = ImageCreateFromJPEG($rImgg.$fav1.$jpg);
}
else { 
$icon1 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
}
if (@getimagesize($rImgg.$fav2.$jpg)) {
$icon2 = ImageCreateFromJPEG($rImgg.$fav2.$jpg);
}
else { 
$icon2 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
}
if (@getimagesize($rImgg.$fav3.$jpg)) {
$icon3 = ImageCreateFromJPEG($rImgg.$fav3.$jpg);
}
else { 
$icon3 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
}
if (@getimagesize($rImgg.$fav4.$jpg)) {
$icon4 = ImageCreateFromJPEG($rImgg.$fav4.$jpg);
}
else { 
$icon4 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
}
if (@getimagesize($rImgg.$fav5.$jpg)) {
$icon5 = ImageCreateFromJPEG($rImgg.$fav5.$jpg);
}
else { 
$icon5 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
}
if (@getimagesize($rImgg.$fav6.$jpg)) {
$icon6= ImageCreateFromJPEG($rImgg.$fav6.$jpg);
}
else { 
$icon6 = ImageCreateFromJPEG($rImgg."erroricon".$jpg);
} 

//
imagecopy($rImg, $icon1, 6, 112, 0, 0, 32, 32);
imagecopy($rImg, $icon2, 42, 112, 0, 0, 32, 32);
imagecopy($rImg, $icon3, 80, 112, 0, 0, 32, 32);
imagecopy($rImg, $icon4, 118, 112, 0, 0, 32, 32);
imagecopy($rImg, $icon5, 156, 112, 0, 0, 32, 32);
imagecopy($rImg, $icon6, 192, 112, 0, 0, 32, 32);
//


// imagecolorallocate ( resource $rImgage , int $red , int $green , int $blue )
$cor = imagecolorallocate($rImg, 255, 255, 255);
$red = imagecolorallocate($rImg, 255, 0, 0);
//
//imagestring($rImg,12,10,5,$gt,$cor); // gamertag



$font = "./sewer.ttf";
// Colors definitions
$white = imagecolorallocate($rImg, 255, 255, 255);
$yellow = imagecolorallocate($rImg, 255, 255, 0);
$purple =  imagecolorallocate($rImg, 89, 3, 255);
$grey = imagecolorallocate($rImg, 128, 128, 128);
$black = imagecolorallocate($rImg, 0, 0, 0);
//$red = imagecolorallocate($rImg, 255, 22, 5);



//check width of the text
$bbox=imagettfbbox (12, 0, $font, $gt);
$xcorr=0-$bbox[6];
$mase=$bbox[2]+$xcorr;

//if(empty($id)) {
//	imagettftextoutline($rImg, 13, 0, 5, 25, $red, $grey, $font, "THERE HAS BEEN AN ERROR" , 2);
//	$erroricon = imagecreatefrompng("error.png");
//	imagesavealpha($erroricon, false);
//	imagealphablending($erroricon, false);
//	imagecopy($rImg, $erroricon, 7, 31, 0, 0, 64, 64); // Generic OFFline picture
//	header('Pragma: public');
//	header('Cache-Control: max-age=86400');
//	header('Content-type: image/jpeg');
//	imagejpeg($rImg,NULL,100);
//	imagedestroy($rImg);
//	die()
//	}

//calculate x coordinates for text
$new=(150-$mase)/2;
if($count == "0") { 
	imagettftextoutline($rImg, 13, 0, 5, 25, $red, $grey, $font, "ERROR USER NOT FOUND" , 2);
	imagettftext($rImg, 25, 0, 90, 100, $black, "./arial.ttf", "Problem?");
	$erroricon = imagecreatefrompng("./error.png");
	imagesavealpha($erroricon, false);
	imagealphablending($erroricon, false);
	imagecopy($rImg, $erroricon, 7, 36, 0, 0, 64, 53); // Error ICON
	$problemicon = imagecreatefrompng("./problem.png");
	imagesavealpha($problemicon, false);
	imagealphablending($problemicon, false);
	imagecopy($rImg, $problemicon, 80, 110, 0, 0, 128, 100); // Trollface problem picture lol...
	}
if($count != "0") {
// GT
imagettftextoutline($rImg, 20, 0, $new, 25, $black, $grey, $font, $gt, 2);
// main card text
imagettftextoutline($rImg, 10, 0, 75, 44, $black, $grey, $font, $ool.$name, 1); // link username
imagettftextoutline($rImg, 10, 0, 75, 54, $black, $grey, $font, $oorep.$rep, 1); // show rep

$isoffline = "Offline last seen";
$isonline = "Online";
////////// if off-line
if ($online == 0)
{
//imagestring($rImg,3,75,60,$isoffline,$red); // y u no online?
imagettftextoutline($rImg, 10, 0, 75, 74, $red, $grey, $font, $isoffline, 1);
//imagestring($rImg,3,75,70,$lastonlinehrs,$red); // how long you been off-line hours
imagettftextoutline($rImg, 10, 0, 75, 84, $red, $grey, $font, $lastonlinehrs, 1);
//imagestring($rImg,3,75,80,$lastonlinemins,$red); // how long you been off-line mins
imagettftextoutline($rImg, 10, 0, 75, 94, $red, $grey, $font, $lastonlinemins, 1);
imagecopy($rImg, $offlineicon, 7, 31, 0, 0, 64, 64); // Generic OFFline picture
}
}


///////// if online
if ($online == 1) {

	imagecopy($rImg, $onlineicon, 7, 31, 0, 0, 64, 64); // Generic online picture if not in lobby
	//imagestring($rImg,3,75,60,$isonline,$cor); // your online yes?
	imagettftextoutline($rImg, 10, 0, 75, 64, $black, $grey, $font, $isonline, 1); // online text
	}

//// if in a game lobby
if($online == 1 && $room != "Main Lobby") { 
if (@getimagesize($rImgg2.$play1.$jpg)) {
$mainicon = ImageCreateFromJPEG($rImgg2.$play1.$jpg);
imagecopy($rImg, $mainicon, 7, 31, 0, 0, 64, 64); // show icon of game if in a lobby and if exists...
}
if (@getimagesize($rImgg2.$play1.$png)) {
$mainicon = ImageCreateFromPNG($rImgg2.$play1.$png);
imagesavealpha($mainicon, false);
imagealphablending($mainicon, false);
imagecopy($rImg, $mainicon, 7, 31, 0, 0, 64, 64); // show icon of game if in a lobby and if exists...
}
//imagestring($rImg,3,75,70,$play3[0],$cor); // what are you playing
	imagettftextoutline($rImg, 10, 0, 75, 74, $black, $grey, $font, $play3[0], 1);
//imagestring($rImg,3,75,80,$play3[1],$cor); // what are you playing
	imagettftextoutline($rImg, 10, 0, 75, 84, $black, $grey, $font, $play3[1], 1);
//imagestring($rImg,3,75,90,$room3[0],$cor); // what room are you in?
	imagettftextoutline($rImg, 10, 0, 75, 94, $black, $grey, $font, $room3[0], 1);
//imagestring($rImg,3,75,100,$room3[1],$cor); // what room are you in?
	imagettftextoutline($rImg, 10, 0, 75, 104, $black, $grey, $font, $room3[1], 1);
}
header('Content-type: image/jpeg');
//header("Expires: Mon, 01 Jul 2003 00:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
imagejpeg($rImg,NULL,100);
imagedestroy($rImg);


?>
