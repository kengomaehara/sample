<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数学科就活</title>
</head>
<body>
<?php
if(empty($_GET)) {
	header("Location: mission_3_6touroku.php");//登録画面に戻る
	exit();
}else{
//GETデータを変数に入れる
 $urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;
 //メール入力判定
 if ($urltoken == ''){
   echo "もう一度登録をやりなおして下さい。";
   }else{

$servername = "";
$username = "";
$password = "";
$dbname = "";
//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableName = mission3_user;
$urltoken = substr( $urltoken , 0 , strlen($urltoken)-1 );//終わりの一文字を削除
$id = substr( $urltoken , 1 , strlen($urltoken)-1 );//頭の1文字を削除

//仮登録のフラグの削除
$stmt2 =  $pdo->prepare("UPDATE $tableName SET id = :id WHERE id = :id2");
$stmt2->bindValue(':id',$id);
$stmt2->bindValue(':id2',$urltoken);
$stmt2->execute();
echo "本登録が完了しました。"."<br>";
echo "id：". $id . "<br>";
echo "パスワード：登録時に入力したもの";
?>

</form>
<form action="mission_3_7login.php" method="post">
  <input type="submit" value="ログイン" /><br />
</form>

<?php
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }
$pdo = null;//切断

 }

}
?>
</body>
</html>
