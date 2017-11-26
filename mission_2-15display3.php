<?php
if(!empty($_POST['edit']) && !empty($_POST['password'])){
 $editNum = $_POST['edit'];
 $editPass = $_POST['password'];
 $sum = 0;//パスワードが一致したかどうか確認するための変数

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
//配列の各要素を分割、編集対象番号、パスワードと比較
  if($editNum == $row['id'] && $editPass == $row['password']){
//編集する投稿のデータを変数に
        $editNumber = $editNum;	
        $editName = $row['name'];
	$editComment = $row['comment'];
	$sum++;//パスワードが一致したことを記録
      }    
   }
//接続失敗したときの処理
}
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
　　die();
    }
$pdo = null;//切断
 if($sum == 1){//$same == 1→パスワードが一致した投稿がある
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PuzzleGame</title>
</head>
<body>

 <form action="mission_2-15display4.php" method="post">
 <input type="hidden" name="editNumber" value="<?=$editNumber?>"><br/>
名前<br/>
 <input type="text" name="newName" size="20" value="<?=$editName?>"><br/>
コメント<br/>
  <input type="text" name="newComment" size="50" value="<?=$editComment?>"><br/>
  <input type="submit" value="編集">
    </form>

<?php
 }else{//$sum が0のまま→パスワードが一致しなかった
 echo "パスワードが間違っています。";
 }

}else{
echo "パスワードを入力してください";
}
?>
</body>
</html>
