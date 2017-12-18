<html>
<head><title>PHP TEST</title></head>
<body>

<?php
$mail = $_POST['address'];

if(empty($_POST['name']) || empty($_POST['address']) || empty($_POST['password'])){
  $error = "未入力の項目があります";

}elseif($_POST['address'] != $_POST['address2']){
  $error = "メールアドレスが一致しません";

}elseif(strlen($_POST['password']) < 8){
  $error = "パスワードは８文字以上入力して下さい";

}elseif($_POST['password'] != $_POST['password2']){
  $error = "パスワードが一致していません";

}elseif(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
  $error = "メールアドレスの形式が正しくありません。";

}else{
		
//接続準備
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

$sql = "SELECT * FROM $tableName";
$stmt = $pdo->query($sql);

//既に登録済みのメールアドレスかどうか確認
foreach ($stmt as $row) {
  if($mail == $row['address']){
    $same = 1;
  }
}

if(!empty($same)){
  $error = "そのメールアドレスは既に登録済みです";

}else{
$id = uniqid(mt_rand(10, 99));//ランダムな文字列を生成
$id = "k" . $id;//仮登録のフラグ
$name = $_POST['name'];
$password = $_POST['password'];

//データ入力
//プリペアドステートメントの利用
$stmt = $pdo->prepare("INSERT INTO $tableName (
	 id, name, password, address
	) VALUES (
	 :id , :name , :password , :address
	)");

//代入する変数の指定
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':address', $mail);

$stmt->execute();//実行

//メールの宛先
$mailTo = $mail;
 
//Return-Pathに指定するメールアドレス
$returnMail = 'web@sample.com';
 
$name = "数学科のための就活口コミサイト";
$mail = 'web@sample.com';
$subject = "【数学科のための就活口コミサイト】会員登録用URLのお知らせ";
$url = "http://co-609.it.99sv-coco.com/mission_3_hontouroku.php" . "?urltoken=" . $id;
 
$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;
 
mb_language('ja');
mb_internal_encoding('UTF-8');
 
//Fromヘッダーを作成
$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
 
   if(mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)){ 	
   echo  "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。"."<br>";
   echo "※パスワードは記録しておいてください";
   }
?>
<!--メイン画面への遷移ボタン-->
<form action="mission_3_main.php" method="post">
  <input type="submit" value="戻る" /><br />
</form>

<?php
  }
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
　　die();
    }
$pdo = null;//切断

}

if(!empty($error)){
echo $error;
?>
<form action="mission_3_6touroku.php" method="post">
  <input type="submit" value="戻る" />
</form>

<?php
}
?>
</body>
</html>
