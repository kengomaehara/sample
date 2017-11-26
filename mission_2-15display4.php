<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
<meta http-equiv="refresh"content="0.01; url=http://co-609.it.99sv-coco.com/mission_2-15.php">
</head>
<body>
<?php
//編集後の名前、コメントを取得
if(isset($_POST['newName'], $_POST['newComment'])){
 $editNumber = $_POST['editNumber'];
 $newName = $_POST['newName'];
 $newComment = $_POST['newComment'];

//接続準備

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully". "<br>"; //接続成功時のメッセージ表示

$tableName = table2_15;
//データの編集
$sql = "UPDATE $tableName SET name = :name, comment = :comment WHERE id = :id";
$stmt = $pdo->prepare($sql);
$params = array(":name" => "$newName", ":comment" => "$newComment", ":id" => "$editNumber");
$stmt->execute($params);
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
　　die();
    }

$pdo = null;//切断
}
?>

</body>
</html>
