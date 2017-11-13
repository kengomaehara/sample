<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
</head>
<body>
<h1>パズルゲームブログ</h1>
<form action="mission_2-6display.php" method="post">
  名前<br/>
 <input type="text" name="name" size="30" value="" /><br />
  コメント<br />
 <input type="text" name="comment" size="30" value="" /><br />
  パスワード（8文字以上16文字以内）：削除・編集時に入力<br />
 <input type="password" name="password" size="16" maxlength="16" /><br />
 <input type="submit" value="送信" /><br />
</form>

<form action="mission_2-6display.php" method="post">
  削除対象番号<br />
  <input type="text" name="delete" size="30" value="" /><br />
  パスワード<br />
  <input type="password" name="deletePassword" size="16" maxlength="16" /><br />
  <input type="submit" value="送信" /><br />
</form>

<form action="mission_2-6display2.php" method="post">
  編集対象番号<br />
  <input type="text" name="edit" size="30" value="" /><br />
  パスワード<br />
  <input type="password" name="password" size="16" maxlength="16" /><br />
  <input type="submit" value="送信" /><br />
</form>

<?php
if ( file_exists( "mission_2-2.txt" )) {
    $getFile = 'mission_2-2.txt';
    $lines = file($getFile);

 foreach ($lines as $line) :
  $pieces = explode("<>", $line);
  
 for($i = 0; $i < 4; $i++){
  echo htmlspecialchars ($pieces[$i] , ENT_QUOTES) ;
  echo nl2br("\n");
 }
  echo nl2br("\n");
  endforeach; 
}

?>

</body>
</html>
