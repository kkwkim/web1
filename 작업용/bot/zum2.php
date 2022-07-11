<?php

    $url = 'https://issue.zum.com/ajax/issue/keyword';   
    $is_post = false;
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, $is_post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec ($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	
    $json = json_decode($response, true);
    
    //print_r($json);
    
	$zum = $json['items'];     
    for($i=0;$i<count($zum);$i++) {
        $keyword[$i] = $zum[$i]['keyword'];
    }


$key = $keyword[array_rand($keyword)];

echo $key;


?>