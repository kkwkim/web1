<?php

$keyword = "SK바이오 주식";

$text1 = array(
"안녕하세요.",
"반갑습니다.",
"오랜만이네요.",
"잘 지내셨어요.",
);

$text2 = array(
"요즘 사회적으로 이슈가 많아 걱정입니다.",
"최근 여러가지 사회적 이슈로 고민이 많습니다.",
"뉴스채널을 틀때마다 사건사고들이 끊이지가 않네요.",
"언제쯤 사회적 이슈들이 사라질까요.",
);

$text3 = array(
"그래서 이번시간에는 ##_keyword_## 관련 내용을 준비해봤습니다.",
"자, 그럼 ##_keyword_## 에 대해 어떤 내용이 있는지 살펴보겠습니다.",
"그럼 이제 ##_keyword_## 관련해서 어떤 사회적 문제가 있는지 알아볼께요.",
"그럼 ##_keyword_## 관련된 이슈들을 정리해봤습니다.",
);

$text4 = array(
"모두가 공감할 수 있었으면 좋겠네요.",
"다같이 공감하고 문제를 해결했으면 좋겠네요.",
"하루 빨리 문제들이 사라졌으면 좋겠습니다.",
"이런 사건사고들이 얼릉 정리되면 좋겠어요.",
);


for($i=0;$i<10;$i++) {
    $article[$i] = $text1[array_rand($text1)]." ".$text2[array_rand($text2)]." ".$text3[array_rand($text3)]." ".$text4[array_rand($text4)];
    //echo '[원본] '.$article.'<br>';
    $result[$i] = replace_word($article[$i], $keyword);
    //echo '[결과] '.$result.'<br>';
}

echo '[원본]<br/>';
for($i=0;$i<10;$i++) {
    echo $article[$i].'<br>';
}

echo '<br/>[결과]<br/>';
for($i=0;$i<10;$i++) {
    echo $result[$i].'<br>';
}

function replace_word($text, $keyword) {    
    $text = str_replace("##_keyword_##" , $keyword, $text);
    return $text;
}

?>