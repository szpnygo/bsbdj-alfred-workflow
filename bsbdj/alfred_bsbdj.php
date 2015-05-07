<?
include_once 'simple_html_dom.php';

function bsbdj(){

	$url="http://www.budejie.com/new-d/";
	$html = file_get_html($url);

	echo("<items>");
	$i=0;
	foreach($html->find('div[class=post-body] p') as $element){

		$iddata=$element->getAttribute('id');
		$id=substr($iddata, 6);

		$data=trim($element->plaintext);

		$index=strpos($data, ",");
		if(empty($index)){
			$index=strpos($data, "，");
		}
		if(empty($index)){
			$index=20;
		}

		$tit = cut_str($data,$index,0);

		echo("<item uid=\"info.smemo.alfred.bdj-$i\">");
		echo("<title>$tit</title>");
		echo("<subtitle>$data</subtitle>");
		echo("<arg>$id</arg>");
		echo("</item>");
		$i++;
	}
	echo("</items>");
}

function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') { 
	if($code == 'UTF-8'){ 
		$pa ="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
		preg_match_all($pa, $string, $t_string); if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."..."; 
		return join('', array_slice($t_string[0], $start, $sublen)); 
	} 
	else { 
		$start = $start*2; 
		$sublen = $sublen*2; 
		$strlen = strlen($string); 
		$tmpstr = ''; 
		for($i=0; $i<$strlen; $i++) { 
			if($i>=$start && $i<($start+$sublen)) 
			{ 
				if(ord(substr($string, $i, 1))>129){ 
					$tmpstr.= substr($string, $i, 2); 
				} 
				else { 
					$tmpstr.= substr($string, $i, 1); 
				} 
			} 
		if(ord(substr($string, $i, 1))>129) 
			$i++; 
		} 
		if(strlen($tmpstr)<$strlen ) 
			$tmpstr.= "..."; 
		return $tmpstr; 
	} 
}