<?php
//include("holidays_$lang.inc");
//include("holidays.inc");
//if ($lang == yd) include("holidays.inc");

$ts = mktime();
$isDiaspora = true;
$postponeShushanPurimOnSaturday = true;
$gyear = date("Y", $ts);
if ($lang == "en"){
$weekdayNames = array("Sunday", "Monday", "Tuesday", "Wednesday",
                        "Thursday", "Friday", "Saturday");
$header = "Nearest date";}
elseif ($lang == "ru"){
//setlocale(LC_TIME, "ru_RU.utf8");
$weekdayNames = array("Воскресенье", "Понедельник", "Вторник", "Среда",
                        "Четверг", "Пятница", "Суббота");
$header = "Ближайшая дата";}
elseif ($lang == "lv"){
$weekdayNames = array("Svētdiena", "Pirmdiena", "Otrdiena", "Trešdiena", 
			"Ceturdiena", "Piektdiena", "Sestdiena");
$header = "Tuvāka date";}

$gmonth = date("m", $ts);
$gday = date("d", $ts);

echo "<h5>$header</h5>";

for ($gmonth; $gmonth <= 12; $gmonth++) {
    $lastGDay = cal_days_in_month(CAL_GREGORIAN, $gmonth, $gyear);
    for ($gday; $gday <= $lastGDay; $gday++) {
$jdCurrent = gregoriantojd($gmonth, $gday, $gyear);
      $weekdayNo = jddayofweek($jdCurrent, 0);
      $weekdayName = $weekdayNames[$weekdayNo];
      $jewishDate = jdtojewish($jdCurrent);
      list($jewishMonth, $jewishDay, $jewishYear) = split('/', $jewishDate);
      $jewishMonthName = getJewishMonthName($jewishMonth, $jewishYear);
      $holidays = getJewishHoliday($jdCurrent, $isDiaspora, $postponeShushanPurimOnSaturday);
//echo "$gmonth $jewishDate";
	if (count($holidays) > 0) {
	$h_ts = mktime(0, 0, 0, $gmonth, $gday, $gyear, -1);
	$h_date = strftime("%d %B %Y", $h_ts); //date("d M Y", $h_ts);
        echo "<div>$weekdayName<br />$h_date<br />$jewishDay $jewishMonthName $jewishYear<br />";
          $holiday = $holidays[0];
          echo "<b>$holiday</b></div>";
	break 2;
        }
      }
$gday = 1;
}
?>
