<?php

$news = getNews("신간");

print_r($news);

function getNews($key) {    

    //$url = 'http://newssearch.naver.com/search.naver?where=rss&query='.urlencode($key);
	$url = 'https://news.google.com/rss/search?q='.urlencode($key).'&hl=ko&gl=KR&ceid=KR%3Ako';
	
    $post=false;
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,$post);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $head=array();
    $head[]="ContentType: text/html; charset=UTF-8";
    $head[]="referer:https://m.naver.com/";
    $head[]="User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
    curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
    $response=curl_exec($ch);
    $status_code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $response = str_replace('<media:thumbnail url="','<img>',$response);
    $response = str_replace('" />','</img>',$response);    
    
    $r = simplexml_load_string($response,'SimpleXMLElement',LIBXML_NOCDATA);
    $r = json_encode($r);
    $r = json_decode($r,true);        
    $r = $r['channel']['item'];

    shuffle($r);
    
    for($i=0;$i<count($r);$i++) {
        
    //if(!$r[$i]['img']) continue;

        $news[$i]['title'] = str_replace("’","", $r[$i]['title']);
        $news[$i]['desc'] = str_replace("‘","", $r[$i]['description']);    
        
        $news[$i]['title'] = str_replace("‘","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("’","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("'","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("'","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("”","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("”","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("“","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("“","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("［","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("［","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("］","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("］","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("▲","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("▲","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("■","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("■","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("▶","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("▶","", $news[$i]['desc']);
        
        $news[$i]['title'] = str_replace("…","", $news[$i]['title']);
        $news[$i]['desc'] = str_replace("…","", $news[$i]['desc']);

        $news[$i]['desc'] = preg_replace("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $news[$i]['desc']);
        $news[$i]['title'] = preg_replace("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $news[$i]['title']);

        $t_date = date("Y-m-d H:i", strtotime($r[$i]['pubDate']));
        $news[$i]['link'] = $r[$i]['link'];
        $news[$i]['author'] = $r[$i]['author'];
        $news[$i]['date'] = $t_date;
        $news[$i]['img'] = $r[$i]['img'];
        $news[$i]['img'] = str_replace("thumb140","thumb400",$news[$i]['img']);    
    }

    return $news;
    
}

?>