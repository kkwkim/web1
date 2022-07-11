<?php

$key = $_GET['key'];

if($key != '') {
    $r = getAutoCompleteKey($key);
}

function getAutoCompleteKey($key) {
    $encText = urlencode($key);
    $url = "https://ac.search.naver.com/nx/ac?_callback=window.__jindo2_callback._$3361_0&q=".$encText."&q_enc=UTF-8&st=100&frm=nx&r_format=json&r_enc=UTF-8&r_unicode=0&t_koreng=1&ans=2&run=2&rev=4&con=1";
    $post=false;
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,$post);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $head=array();
    $head[]="ContentType: text/html; charset=UTF-8";
    $head[]="referer:https://m.search.naver.com/";
    $head[]="User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
    curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
    $response=curl_exec($ch);
    $status_code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    preg_match_all('/\["(.*?)", "[^d]"\]/', $response, $result);
    return $result[1];
}

?>
<form method="get" action="">
    <input type="text" name="key" />
    <input type="submit" value="검색" />
</form>

<pre>
<?php print_r($r); ?>
</pre>