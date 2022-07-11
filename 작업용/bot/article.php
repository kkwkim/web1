<?php

$text1 = file('_a1.txt'); $text1 = isset($text1[0]) ? $text1 : '';
$text2 = file('_a2.txt'); $text2 = isset($text2[0]) ? $text2 : '';
$text3 = file('_a3.txt'); $text3 = isset($text3[0]) ? $text3 : '';
$text4 = file('_a4.txt'); $text4 = isset($text4[0]) ? $text4 : '';

?>
<!doctype html>
<html lang="ko">
<head>
<title>글감 외주화, 치환자</title>
</head>
<body>
<?php for($i=0;$i<10;$i++) { ?>
<p><?=($i+1);?>. <?=$text1[array_rand($text1)];?> <?=$text2[array_rand($text2)];?> <?=$text3[array_rand($text3)];?> <?=$text4[array_rand($text4)];?></p>
<?php } ?>
</body>
</html>