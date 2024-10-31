<?
//include ("functions.php");
include ("hdate/hdate.php");
?>
<style>
#shabat_message {
	position:fixed;
	width: 400px;
/*	height: 100px;*/
	top:0;
	left: 30%;
	border: 5px solid #990000;
	background-color:#ffffff;
	opacity:0.6;
	filter:alpha(opacity=60);
	z-index: 99;
}
.shfont {
	color: #000066;
	font-size: 16px;
	font-weight: bold;
}
</style>
<div id="shabat_message">
<?
if(get_option('shabat-keeperHTML')) {
	echo ucGetHTML('shabat-keeperHTML');
}else{
?>
<p class="shfont">Comments on Kosherdev.com are closed for Shabat</p>
<p class="shfont">You are from <? 
if ($city!='') print $city.', ';
if ($region!='') print ' ('.$region.')';
print $country;?></p>
<p class="shfont">It will be possible to comment after <? print $sh_date_end." ".$resultHour_end.":".$resultMin_end;?></p>
<?}
//print $shlat.', '.$shlong.', '.$shoffset.', '.$shgmt;
?>
</div>
