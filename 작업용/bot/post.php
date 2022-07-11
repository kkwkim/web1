<?PHP
    // 우리는 bot 이라는 폴더안에서 작성을 했기 때문에 아래와 같이 워드프레스가 설치된 곳(루트)의 wp-load.php 파일을 불러와야합니다.
    require_once("../wp-load.php");
    /*******************************************************
    ** 변수 설명
    *******************************************************/
    $postType = 'post'; // post 를 할지 page 로 할지 선택
    $userID = 1; // 유저 설정
    $categoryID = '2'; // 카테고리 번호
    $postStatus = 'publish';  // future : 예약, draft: 임시저장, publish: 발행
    $leadTitle = '테스트 제목입니다.';
    $leadContent = '<p>테스트로 작성된 글입니다.</p><p style="color:red">붉은색 글자 테스트 잘 보이나요?</p>';
    
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
?>