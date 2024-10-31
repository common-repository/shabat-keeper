<?
include("holidays_$lang.inc");

$ts = mktime();
$ts_t = mktime();
$resultStr_t = date_sunset($ts, SUNFUNCS_RET_STRING, 55+53/60, 26+32/60, 90+50/60, 2);
list($resultHour_t, $resultMin_t) = split(':', $resultStr_t);
$time_s = "$resultHour_t:$resultMin_t";
$time_t = date("H:i", $ts);
if ($time_t > $time_s) $ts = ($ts + 60*60*24);

$gmonth_t = date("m", $ts);
$gday_t = date("d", $ts);
$gyear_t = date("Y", $ts);

$jdCurrent_t = gregoriantojd($gmonth_t, $gday_t, $gyear_t);
$jewishDate_t = jdtojewish($jdCurrent_t);
list($jewishMonth_t, $jewishDay_t, $jewishYear_t) = split('/', $jewishDate_t);
$jewishMonthName_t = getJewishMonthName($jewishMonth_t, $jewishYear_t);
$h_ts_t = mktime();
$h_date_t = strftime("%d %B %Y", $h_ts_t); //date("d M Y", $h_ts);
echo "<div>$h_date_t<br />$jewishDay_t $jewishMonthName_t $jewishYear_t</div>";
?>
