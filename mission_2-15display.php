<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
</head>
<body>

<?php
if(strlen($_POST['password']) >= 8){//パスワードが入力されているか確認
  if(isset($_POST['name'], $_POST['comment'])) {

//入力内容を整理
$name = $_POST['name'];
$comment = $_POST['comment'];
$date = new DateTime();
$password = $_POST['password'];

//MySQLへの接続    



try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//テーブルを指定し、変数に格納
$tableName = table2_15;

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

//送信後元の画面に戻る
$uri = $_SERVER['HTTP_REFERER'];
header("Location: ".$uri);

 }
}else{
echo "パスワードを入力してください";
}
?>
</body>
</html>
