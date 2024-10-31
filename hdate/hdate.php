<?
//include "functions.php";
$ipi = getenv("REMOTE_ADDR");
//list($shlat, $shlong, $shoffset, $shgmt)=locateIp($ipi);
foreach (locateIp($ipi) as $opt=>$val)
{
	$$opt=$val;
}
if ($shlat=='' || $shlong == '' || $shoffset == ''):
	if(get_option('shabat-keeperLat')) $shlat=get_option('shabat-keeperLat'); 
	else $shlat=59+26/60;
	if(get_option('shabat-keeperLong')) $shlong=get_option('shabat-keeperLong');
	else $shlong=24+44/60;
	if(get_option('shabat-keeperOffset')) $shoffset=get_option('shabat-keeperOffset');
	else $shoffset=2;
endif;
date_default_timezone_set('UTC');
#day of week
$ts = mktime();

$weekday = date("w", $ts);
//echo $weekday;
$leftshabat = (5 - $weekday);
$endshabat = (6 - $weekday);

$ts_start = ($ts + (60 * 60 * 24 * $leftshabat)+(60 * 60 *$shoffset));
$ts_end = ($ts + (60 * 60 * 24 * $endshabat)+(60 * 60 *$shoffset));
//$leftshabat++;

$tslocal = date("Z", $ts_start); 
/*if ($tslocal == "7200"){
	$timediff = "0";
}else{
	$timediff = "1";
}*/

$resultStr = date_sunset($ts_start, SUNFUNCS_RET_STRING, $shlat, $shlong, 90+50/60, $shoffset);
list($resultHour, $resultMin) = split(':', $resultStr);
//$resultHour += $timediff;
$resultMin -= 18;

while ($resultMin < 0) {
  $resultMin += 60;
  $resultHour--;
}

$tslocal = date("Z", $ts_end);
        $timediff_end = "1";
/*if ($tslocal == "7200"){
}else{
        $timediff_end = "2";
}*/

$resultStr_end = date_sunset($ts_end, SUNFUNCS_RET_STRING, $shlat, $shlong, 90+50/60, $shoffset);
list($resultHour_end, $resultMin_end) = split(':', $resultStr_end);
$resultHour_end += $timediff_end;
//$resultMin_end += 40;

while ($resultMin_end >= 60) {
  $resultMin_end -= 60;
  $resultHour_end++;
}

$sh_date = strftime("%d %B", $ts_start); //date("d M", $ts_start);
$sh_date_end = strftime("%d %B", $ts_end);//date("d M", $ts_end);
$currentHour = date("G", ($ts+(60 * 60 *$shoffset)));
$currentMin = date("i", ($ts+(60 * 60 *$shoffset)));
//$currentHour =23;
$leftHour=($resultHour - $currentHour);
$leftMin=($resultMin - $currentMin);
if ($leftMin < 0) {$leftMin += 60;
$leftHour --;}
if (strlen($leftMin) <2) $leftMin="0$leftMin";

if ($leftshabat > 1) $nday="$left $leftshabat $day_2";
if ($leftshabat >= 4) $nday="$left $leftshabat $day_5";
if ($leftshabat ==1) $nday="$left $leftshabat $day_1";
if ($leftshabat <1) $nday="$left $leftHour:$leftMin"; 

//echo "$currentHour:$currentMin $resultHour:$resultMin";

/*if ($weekday == 6 && "$currentHour:$currentMin" < "$resultHour_end:$resultMin_end") $nday="$shab";
elseif ($weekday == 5 && "$currentHour$currentMin" > "$resultHour$resultMin") $nday="$shab";
elseif ($weekday >= 6  && $leftHour < 0 ) $nday="$left 6 $day_5";*/

/*if ( strlen($resultMin) < 2 && $resultMin == 0) $resultMin=$resultMin.'0';
if ( strlen($resultMin) < 2 && $resultMin > 0) $resultMin='0'.$resultMin; 
if ( strlen($resultMin_end) < 2 && $resultMin_end == 0) $resultMin=$resultMin_end.'0';
if ( strlen($resultMin_end) < 2 && $resultMin_end > 0) $resultMin='0'.$resultMin_end;

echo "<h5>$shtime</h5>";
echo "<p><b>$nday.</b></p>";

echo "<div align=\"center\">
<ul>$lig $can <li> $sh_date $resultHour:$resultMin </li></ul>
<ul>$shab $end <li> $sh_date_end $resultHour_end:$resultMin_end</li><ul>
</div>";*/
?>
