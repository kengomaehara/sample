<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数学科就活－ワンポイントアドバイス</title>
</head>
<body>

<?php
session_start();

// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
  header("Location: mission_3_7logout.php");
  exit;
}
echo "　ようこそ" . $_SESSION["NAME"] . "さん";
?>

　<a href="mission_3_7logout.php">ログアウト</a>
　<a href="mission_3_main.php">メイン画面に戻る</a>
　<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>

<h2>新規投稿画面</h2>

<?php
//投稿をデータベースに保存
if (isset($_POST["toukou"])) {

//タイトル、コメントの有無を確認
if(empty($_POST["title"]) || empty($_POST["comment"])){
  echo "タイトルとコメントを入力してください";
  
}else{

$title = $_POST["title"];
$comment = nl2br($_POST["comment"]);

$servername = "";
$username = "";
$password = "";
$dbname = "";

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = mission3_advice;
$sql = "SELECT * FROM $tableName";
$stmt = $pdo->query($sql);

//既に同じタイトルの投稿があるか確認
foreach ($stmt as $row) {
  if($title == $row['title']){
    $same = 1;
  }
}

if(!empty($same)){
  echo  "<br>" . "<br>" ."そのタイトルの投稿は既に存在しています" . "<br>" . "タイトルを変更して下さい"."<br>";

}else{
//データ入力
//プリペアドステートメントの利用
$stmt = $pdo->prepare("INSERT INTO $tableName (
	name, title, comment
	) VALUES (
	:name , :title , :comment
	)");

//代入する変数の指定
$stmt->bindParam(':name', $_SESSION["NAME"]);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':comment', $comment);

$stmt->execute();//実行

   header("Location: mission_3_toukoukanryou.php?title=$title");//投稿完了ページへ移動
   exit;

  }
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }
  
  }
}
?>
<br/>
<form action="mission_3_advicetoukou.php" method="post">
  タイトル：<br />
  <input type="text" name="title" size="30" value="" /><br />
  コメント：<br />
  <textarea name="comment" cols="90" rows="5"></textarea><br /><br/>
  <input type="submit" name="toukou" value="投稿" />
</form>

<br/>
<form action="mission_3_advice.php" method="post">
  <input type="submit" value="戻る" />
</form>

</body>
</html>
