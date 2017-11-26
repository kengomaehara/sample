<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
</head>
<body>
<?php
if(!empty($_POST['delete']) && !empty($_POST['deletePassword'])){
  
 $delNum = $_POST['delete'];
 $delPass = $_POST['deletePassword'];
 $same = 0;//パスワードが一致したかどうか確認するための変数

//接続準備

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = table2_15;
// データをを変数に格納
$sql = "SELECT * FROM $tableName";
$stmt = $pdo->query($sql);

// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
  if($delNum == $row['id'] && $delPass == $row['password']){

//データの削除
    $stmt2 = $pdo->prepare("DELETE FROM $tableName WHERE id = :id");
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
//送信後元の画面に戻る
$uri = $_SERVER['HTTP_REFERER'];
header("Location: ".$uri);

}else{//$sum が0のまま→パスワードが一致しなかった
echo "パスワードが間違っています";
}

}else{
echo "パスワードを入力してください";
}
?>
</body>
</html>
