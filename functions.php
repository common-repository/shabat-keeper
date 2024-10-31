<?php


function ucGetHTML($option)
{
	return stripslashes(html_entity_decode(get_option($option)));
}

function locateIp($ip){
	$url="http://www.ipinfodb.com/ip_query.php?ip=$ip&output=xml";
	$d = file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=xml");
	$answer = new DOMDocument(); 
	//Use backup server if cannot make a connection
	if (!$d){
		$backup = "http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=xml";
		$answer->load($backup);
		if (!$backup) return false; // Failed to open connection
	}else{
		$answer->load($url);
	}
	$options_ar= array(
		'shlat'=>'Latitude',
		'shlong' => 'Longitude',
		'shoffset' => 'Gmtoffset',
		'shdst' => 'Dstoffset',
		'city'=>'City',
		'region'=>'RegionName',
		'country'=>'CountryName'
	);
	     $array_element = new DOMDocument();
   if (!$array_element=$answer->GetElementsByTagName("Response")) die("Error opening xml file");
   $hawbid_dom = $array_element->item(0);
	foreach ($options_ar as $value=>$opt)
        {
                $general_dom = $hawbid_dom->getElementsByTagName($opt);
                $result[$value]=$general_dom->item(0)->nodeValue;
        } 
 
	//Return the data as an array
	return $result;
	//return array('ip' => $ip, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'timezone' => $timezone, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
//	return array('latitude' => $latitude, 'longitude' => $longitude, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
}
 
?>
