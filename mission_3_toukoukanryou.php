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
<title>数学科就活－アドバイス投稿完了</title>
</head>
<body>
　<a href="mission_3_7logout.php">ログアウト</a>
　<a href="mission_3_main.php">メイン画面に戻る</a>
　<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>

<?php
if(isset($_GET["title"])){
$title = $_GET["title"];

}elseif(isset($_POST["title"])){
$title = $_POST["title"];
}
?>

<h2>投稿完了しました</h2>
</form>
<form action="mission_3_advice.php" method="post">
  <input type="submit" value="投稿一覧に戻る" />
</form>

<h3>画像・動画を追加する場合はこちらから</h3>
 <form action="mission_3_toukoukanryou.php" enctype="multipart/form-data" method="post">
        <input type="file" name="upfile">
        <br>
        ※画像はjpg方式，png方式，gif方式に対応しています．動画はmp4方式のみ対応しています．<br>
	<input type="hidden" name="title" value="<?=$title?>"><br/>
        <input type="submit" name="file" value="アップロード">
 </form>

<?php

$error = "";//エラーメッセージの初期化

//ファイルの存在を確認
if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
  $title = $_POST["title"];
  $filename = $_FILES["upfile"]["name"];//ファイル名を取り出す
  $type = substr($filename, -3);//拡張子を取り出す

  //拡張子の判定
  if($type != "jpg" && $type != "gif" && $type != "png" && $type != "mp4"){
    $error = "拡張子がjpgとgifとpngとmp4の場合のみアップできます";

  }elseif($_FILES["upfile"]["size"] > 15000000){//ファイルのサイズの確認
  $error = "サイズが大き過ぎます";
 
  }else{

//バイナリデータの処理
    $fp = fopen($_FILES["upfile"]["tmp_name"], "rb");
    $imgdat = fread($fp, filesize($_FILES["upfile"]["tmp_name"]));
    fclose($fp);
    $raw_data = $imgdat;

   //ファイルの名前の変更
   $date = getdate();
   $filename = $_FILES["upfile"]["name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];  
  }

  if($error != ""){
  echo $error; 
  }else{

$servername = "";
$username = "";
$password = "";
$dbname = "";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//データの追加
$tableName = mission3_advice;
$title = $_POST["title"];

//タイトルからデータを検索して代入
$stmt2 = $pdo->prepare("UPDATE $tableName SET filename = :filename , type = :type , raw_data = :raw_data WHERE title = :title");
$stmt2->bindValue(':filename',$filename);
$stmt2->bindValue(':type',$type);
$stmt2->bindValue(':raw_data',$raw_data);
$stmt2->bindValue(':title',$title);
$stmt2->execute();

echo "アップロードが完了しました";

}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }
$pdo = null;//切断

     }

}elseif(isset($_POST["file"])) {
echo "ファイルが見つかりません"."<br>";
$title = $_POST["title"];

   }
?>
</body>
</html>
