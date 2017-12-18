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
<title>数学科就活－ワンポイントアドバイス</title>
</head>
<body>
　<a href="mission_3_7logout.php">ログアウト</a>
　<a href="mission_3_main.php">メイン画面に戻る</a>
　<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>

<h2>数学科のためのなんでもアドバイス</h2>
<h3>投稿一覧</h3>

<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SELECT文を変数に格納
$sql = "SELECT * FROM mission3_advice";
// SQLステートメントを実行し、結果を変数に格納
$stmt = $pdo->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
  foreach ($stmt as $row) {
  $id = $row['id'];
  $title = $row['title'];
  echo "・"."<a href=\"mission_3_advicedisplay.php?id=$id\">$title</a>"."<br>";
  }

}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }
?>
<br>
<form action="mission_3_advicetoukou.php" method="post">
  <input type="submit" value="新規投稿" />
</form>
<form action="mission_3_toppage.php" method="post">
  <input type="submit" value="戻る" />
</form>

</body>
</html>
