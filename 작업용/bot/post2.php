<?PHP

$keyword = $_GET['keyword'];


if($keyword != '') {
	$news = getNews($keyword);
	for($i=0;$i<count($news);$i++) {
		if($news[$i]['title'] == '') continue;        
		$list[] = $news[$i];
	}

	$title = $list[0]['title'];
	$desc = '<div class="wrap">';

	for($i=0;$i<count($list);$i++) {
		$desc .= '<a href="'.$list[$i]['link'].'">';
		$desc .= '<div class="news-box">';
		$desc .= '<div class="image"><img src="'.$list[$i]['img'].'" /></div>';
		$desc .= '<div class="title">'.$list[$i]['title'].'</div>';
		$desc .= '<div class="desc">'.$list[$i]['desc'].'</div>';            
		$desc .= '<div class="author">'.$list[$i]['author'].'</div>';
		$desc .= '</div>';
		$desc .= '</a>';
	}
	$desc .= '</div>';

	

	$desc = $style.$desc;

	autoPost($title, $desc);	
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
		$news[$i]['link'] = $r[$i]['link'];   
			break;
	}

	return $news;
    
}

function autoPost($title, $desc) {
    // 우리는 bot 이라는 폴더안에서 작성을 했기 때문에 아래와 같이 워드프레스가 설치된 곳(루트)의 wp-load.php 파일을 불러와야합니다.
    require_once("wp-load.php");
    /*******************************************************
    ** 변수 설명
    *******************************************************/
    $postType = 'post'; // post 를 할지 page 로 할지 선택
    $userID = 1; // 유저 설정
    $categoryID = '2'; // 카테고리 번호
    $postStatus = 'publish';  // future : 예약, draft: 임시저장, publish: 발행
    $leadTitle = $title;
    $leadContent = $desc;
    
    $timeStamp = date('Y-m-d H:i:s', strtotime("+9 hour"));
    
    $new_post = array(
    'post_title' => $leadTitle,
    'post_content' => $leadContent,
    'post_status' => $postStatus,
    'post_date' => $timeStamp,
    'post_author' => $userID,
    'post_type' => $postType,
    'post_category' => array($categoryID)
    );
    
    $post_id = wp_insert_post($new_post);
    
    $finaltext = '';
    if($post_id){
        $finaltext .= '포스팅 성공<br>';
    } else{
        $finaltext .= '포스팅 실패!<br>';
    }
    echo $finaltext;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>실시간검색어 자동문서 생성 - news3.php</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
.wrap { margin:10px auto; width: 440px; }
.wrap .news-box { border:1px solid #333; margin:10px auto; font-size:12px; }
.wrap .news-box .image { max-height:300px; overflow:hidden; }
.wrap .news-box img { width:100%; }
.wrap .news-box .title { padding:5px; font-weight:bold; font-size:14px; }
.wrap .news-box .desc { padding:5px; color:#666; }
.wrap .news-box .date { padding:5px; color:green; }
.wrap .news-box .author { padding:5px; color:blue; }
.wrap .result-title { padding:10px; border:1px solid #000; margin:10px 0 0; background:#eee;}

.wrap .result-post-btn { padding:10px; border:1px solid #000; background:green; color:#fff; margin:10px 0; }
.wrap .result-post-btn:hover { cursor:pointer; background:#004e00; }
.wrap a { color:#000; text-decoration:none; }
</style>
</head>
<body>
<div class="wrap">

<form method="get" action="">
    <input type="text" name="keyword" value="<?=$keyword;?>"/>
    <input type="submit" value="발행" />
</form>

<?php if($title != '' && $desc != '') { ?>
<?php echo $desc; ?>
<?php } ?>	

</div>
</body>
</html>