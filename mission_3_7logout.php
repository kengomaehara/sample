<?php
session_start();

if (isset($_SESSION["USERID"])) {
  $errorMessage = "ログアウトしました。";

//ログインテーブルのデータ削除

$servername = "";
$username = "";
$password = "";
$dbname = "";
//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = mission3_userlogin;
// データをを変数に格納
$sql = "SELECT * FROM $tableName";
$stmt = $pdo->query($sql);

// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
  if($_SESSION["USERID"] == $row['anotherid']){

//データの削除
    $stmt2 = $pdo->prepare("DELETE FROM $tableName WHERE id = :id");
    $stmt2->bindValue(':id',$row['id'] );
    $stmt2->execute();
  }
}

}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }

$pdo = null;//切断

//セッション変数のクリア
$_SESSION = array();
// セッションクリア
@session_destroy();

}
else {
  $errorMessage = "セッションがタイムアウトしました。";
}

?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>数学科就活－ログアウト</title>
  </head>
  <body>
  <div><?php echo $errorMessage; ?></div>
  <ul>
<a href="mission_3_7login.php">ログイン画面に戻る</a>
  </ul>
 <ul>
<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>
 </ul>
  </body>
</html>
