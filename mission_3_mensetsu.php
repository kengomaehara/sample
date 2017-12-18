<?php
session_start();

// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
  header("Location: mission_3_7logout.php");
  exit;
}

echo "　ようこそ" . $_SESSION["NAME"] . "さん";
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数学科就活－面接</title>
</head>
<body>
　<a href="mission_3_7logout.php">ログアウト</a>
　<a href="mission_3_main.php">メイン画面に戻る</a>
　<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>

<h3>数学科なんでも掲示板</h3>
<h1>面接</h1>

<form action="mission_3_mensetsu.php" method="post">
  コメント<br />
  <textarea name="comment" cols="90" rows="5"></textarea><br /><br/>
  パスワード（8文字以上16文字以内）：削除・編集時に入力<br />
 <input type="password" name="password" size="16" maxlength="16" /><br />
 <input type="submit" name="postcomment" value="送信" /><br />
</form>

<form action="mission_3_keijiban.php" method="post">
  <input type="submit" value="戻る" />
</form>

<?php
// 送信ボタンが押された場合
if (isset($_POST["postcomment"])){

  if(empty($_POST['comment']) || empty($_POST['password'])){
  echo "コメントまたはパスワードが未入力です";

  }elseif(strlen($_POST['password']) < 8){
  echo "パスワードは８文字以上入力してください";

  }else{

//投稿内容を整理
$name = $_SESSION["NAME"];
$comment = nl2br($_POST["comment"]);
$date = new DateTime();
$password = $_POST['password'];

//MySQLへの接続    
$servername = "";
$username = "";
$password = "";
$dbname = "";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = mission3_mensetsu;
//データ入力
//プリペアドステートメントの利用
$stmt = $pdo->prepare("INSERT INTO $tableName (
	 name, comment, registry_datetime, password
	) VALUES (
	 :name , :comment , :date , :password
	)");

//代入する変数の指定
$stmt->bindParam(':name', $name);
$stmt->bindParam(':comment', $comment);
$stmt->bindParam(':date', $date->format('Y/m/d H:i:s'));
$stmt->bindParam(':password', $password);

$stmt->execute();//実行

}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
　　die();
    }
$pdo = null;//切断

  }
}

//接続準備
$servername = "";
$username = "";
$password = "";
$dbname = "";
//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName2 = mission3_mensetsu;//テーブルの指定

// データをを変数に格納
$sql = "SELECT * FROM $tableName2";
$stmt = $pdo->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
 
  echo "No.".$row['id']."　" .$row['name']."　". $row['registry_datetime'] . '<br>';
  echo $row['comment'].'<br>' .'<br>';
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

<h4>投稿の削除はこちらから（パスワードの入力が必要です)</h4>
<form action="mission_3_mensetsu.php" method="post">
  番号(数字のみを半角で入力してください)<br/>
  <input type="text" name="delete" size="5" value="" /><br />
  パスワード<br/>
  <input type="password" name="deletePassword" size="16" maxlength="16" /><br />
  <input type="submit" name="postdelete" value="削除" /><br />
</form>

<form action="mission_3_keijiban.php" method="post">
  <input type="submit" value="戻る" />
</form>

<?php
if (isset($_POST["postdelete"])){

  if(!empty($_POST['delete']) && !empty($_POST['deletePassword'])){
  
 $delNum = $_POST['delete'];
 $delPass = $_POST['deletePassword'];
 $same = 0;//パスワードが一致したかどうか確認するための変数

//接続準備
$servername = "";
$username = "";
$password = "";
$dbname = "";
//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName3 = mission3_mensetsu;
// データをを変数に格納
$sql = "SELECT * FROM $tableName3";
$stmt = $pdo->query($sql);

// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
  if($delNum == $row['id'] && $delPass == $row['password']){

//データの削除
    $stmt2 = $pdo->prepare("DELETE FROM $tableName3 WHERE id = :id");
    $stmt2->bindValue(':id', $row['id']);
    $stmt2->execute();
    $same++;//パスワードが一致したことを記録
  }
}

}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }

$pdo = null;//切断

if($same == 1){//$same == 1→パスワードが一致した投稿がある
 echo "投稿を削除しました";

}else{//$sum が0のまま→パスワードが一致しなかった
echo "パスワードが間違っています";
}

 }else{
 echo "番号またはパスワードを入力してください";
 }

}
?>
</body>
</html>
