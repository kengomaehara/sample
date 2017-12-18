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

<?php
if(isset($_GET["id"])){
 $id = $_GET["id"];//idの受け取り

$servername = "";
$username = "";
$password = "";
$dbname = "";
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM mission3_advice WHERE id = :id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":id", $id, PDO::PARAM_STR);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        echo "<br/>" . "<br/>" . $row["title"] . "　　" . "投稿者：" . $row["name"] . "<br/>". "<br/>";
        echo $row["comment"] . "<br/>";
 
//画像・動画の表示
	if(isset($row["type"])){ 

      //動画と画像で場合分け
        if($row["type"] == "mp4"){
	echo "<br>" . "・"."<a href=\"mission_3_import.php?id=$id\">動画はこちら</a>"."<br>";

        }else{
	echo "<br>" . "・"."<a href=\"mission_3_import.php?id=$id\">画像はこちら</a>"."<br>";
	}
    
	}
}
//接続失敗したときの処理
catch(PDOException $e)
    {
    echo "Connection failed: " . "<br>" . $e->getMessage();
    }
}

?>
<br>
<form action="mission_3_advice.php" method="post">
  <input type="submit" value="戻る" />
</form>
</body>
</html>
