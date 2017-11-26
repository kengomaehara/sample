<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
</head>
<body>
<h1>パズルゲームブログ</h1>
<form action="mission_2-15display.php" method="post">
  名前<br/>
 <input type="text" name="name" size="20" value="" /><br />
  コメント<br />
 <input type="text" name="comment" size="50" value="" /><br />
  パスワード（8文字以上16文字以内）：削除・編集時に入力<br />
 <input type="password" name="password" size="16" maxlength="16" /><br />
 <input type="submit" value="送信" /><br />
</form>

<form action="mission_2-15display2.php" method="post">
  削除対象番号<br />
  <input type="text" name="delete" size="1" value="" /><br />
  パスワード<br />
  <input type="password" name="deletePassword" size="16" maxlength="16" /><br />
  <input type="submit" value="送信" /><br />
</form>

<form action="mission_2-15display3.php" method="post">
  編集対象番号<br />
  <input type="text" name="edit" size="1" value="" /><br />
  パスワード<br />
  <input type="password" name="password" size="16" maxlength="16" /><br />
  <input type="submit" value="送信" /><br />
</form>

<?php
//接続準備

//アカウント情報非公開

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = table2_15;//テーブルの指定

// データをを変数に格納
$sql = "SELECT * FROM $tableName";
$stmt = $pdo->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
 
  echo "投稿番号：".$row['id']. '<br>'. "名前：" .$row['name'].'<br>';
  echo $row['comment'].'<br>' .$row['registry_datetime'].'<br>'.'<br>';
  }
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
　　die();
    }

$pdo = null;//切断
?>

</body>
</html>
