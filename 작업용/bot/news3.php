<?php

$news = getNews("러시아");

for($i=0;$i<count($news);$i++) {
    if($news[$i]['title'] == '') continue;
    
    $list[] = $news[$i];
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
			break;
	}

	return $news;
    
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>실시간검색어 자동문서 생성 - news3.php</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
.wrap { margin:10px auto; width: 380px; }
.wrap .news-box { border:1px solid #333; margin:10px auto; font-size:12px; }
.wrap .news-box .image { max-height:300px; overflow:hidden; }
.wrap .news-box img { width:100%; }
.wrap .news-box .title { padding:5px; font-weight:bold; font-size:14px; }
.wrap .news-box .desc { padding:5px; color:#666; }
.wrap .news-box .date { padding:5px; color:green; }
.wrap .news-box .author { padding:5px; color:blue; }

</style>
</head>
<body>
<div class="wrap">
<?php for($i=0;$i<count($list);$i++) { ?>
<div class="news-box">
    <div class="image"><img src="<?php echo $list[$i]['img'];?>"></div>
	<div class="content">
		<div class="title"><?php echo $list[$i]['title']; ?></div>
		<div class="desc"><?php echo $list[$i]['desc']; ?></div>
		<div class="author"><?php echo $list[$i]['author']; ?></div>
	</div>
</div>
<?php } ?>
</div>
</body>
</html>