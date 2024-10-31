<?
include("functions.php");
$ipi = getenv("REMOTE_ADDR");
print_r(locateIp($ipi));
print '<pre>'.file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ipi&output=xml").'</pre>';
?>
