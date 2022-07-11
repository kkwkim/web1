<?PHP

$keyword = getKeyword();

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

	$desc = $desc;
	
	echo '키워드: '.$keyword.'<br>';
    echo '제목: '.$title.'<br>';
    echo '포스팅: ';

	autoPost($title, $desc);	
}

function getKeyword() {
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

    return $key;
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