<?php
// セッション開始
session_start();

// ログイン状態のチェック
if (isset($_SESSION["USERID"])) {
   	   header("Location: mission_3_toppage.php");//ログイン済みならトップページへ移動
   	   exit;
}else{

//データベース接続準備
$servername = "";
$username = "";
$pass = "";
$dbname = "";

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {

  // １．ユーザIDの入力チェック
  if (empty($_POST["userid"])) {
    $errorMessage = "ユーザIDが未入力です。";

  }elseif(empty($_POST["password"])) {
    $errorMessage = "パスワードが未入力です。";

  //仮登録状態かどうか判定
  }elseif(substr($_POST["userid"], 0, 1) == "k"){
    $errorMessage = "本登録が完了していません。";

  }else{

//接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$tableName = mission3_user;
	$sql = "SELECT * FROM $tableName";
	$stmt = $pdo->query($sql);
	$same = 0;

	// foreach文で配列の中身を一行ずつ出力
	foreach ($stmt as $row) {
	  if($_POST["userid"] == $row['id'] && $_POST["password"] == $row['password']){

	  //セッションの生成
   	   session_regenerate_id(true);
   	   $_SESSION["USERID"] = uniqid();
   	   $_SESSION["NAME"] = $row['name'];	   
	   $id = $row['id'];
	   $password = $row['password'];

//セッションを別のテーブルに入力
//プリペアドステートメントの利用
$logintable = mission3_userlogin;
$stmt = $pdo->prepare("INSERT INTO $logintable (
	 anotherid, id, name, password
	) VALUES (
	 :anotherid , :id , :name , :password
	)");

//セッションとユーザー情報を入力
$stmt->bindParam(':anotherid', $_SESSION["USERID"]);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $_SESSION["NAME"]);
$stmt->bindParam(':password', $password);

$stmt->execute();//実行

   	   header("Location: mission_3_toppage.php");//トップページへ移動
   	   exit;
	   $same ++;
      }
 }
 if($same == 0){
     $errorMessage = "idまたはパスワードが間違っています。";
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
  }
}
?>

<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>数学科就活ーログイン</title>
  </head>
  <body>
  <h1>ログイン</h1>
  <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
  <!--<form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">-->
  <form id="loginForm" name="loginForm" action="" method="POST">
  <div><?php echo $errorMessage ?></div>
  <label for="userid">ユーザID　：</label><input type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
  <br>
  <label for="password">パスワード：</label><input type="password" id="password" name="password" value="">
  <br>
  <input type="submit" id="login" name="login" value="ログイン">
  </form>
<br>
<form action="mission_3_main.php" method="post">
  <input type="submit" value="戻る" /><br />
</form>
  </body>
</html>
