<?php

$news = getNews("신간");

for($i=0;$i<count($news);$i++) {
	if($news[$i]['title'] == '') continue;
	echo '제목: '.$news[$i]['title'].'<br>';
	echo '내용: '.$news[$i]['desc'].'<br>';
	echo '언론사: '.$news[$i]['author'].'<br>';	
	echo '썸네일: <img src="'.$news[$i]['img'].'"><br>';
	echo '<hr>';
}

function getNews($key) {

	$url = 'https://s.kimanote.com/news/?query='.urlencode($key);

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

	//print_r($response);
	$r = json_decode($response, true);
	//return;
	//print_r($r);
	shuffle($r);

	for($i=0;$i<count($r);$i++) {
		$r[$i]['desc'] = strip_tags($r[$i]['desc']);

		$news[$i]['title'] = str_replace("’","", $r[$i]['title']);
		$news[$i]['desc'] = str_replace("‘","", $r[$i]['desc']);    
		
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
		
		$news[$i]['title'] = str_replace("◆","", $news[$i]['title']);
		$news[$i]['desc'] = str_replace("◆","", $news[$i]['desc']);
		
		$news[$i]['title'] = str_replace("●","", $news[$i]['title']);
		$news[$i]['desc'] = str_replace("●","", $news[$i]['desc']);
		
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
		$news[$i]['source'] = $r[$i]['source'];
		$news[$i]['img'] = $r[$i]['img'];        
	}

	return $news;
    
}

?>