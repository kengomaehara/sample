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
<title>数学科就活－トップページ</title>
</head>
<body>
　<a href="mission_3_7logout.php">ログアウト</a>
　<a href="mission_3_main.php">メイン画面に戻る</a>
　<a href="http://co-609.it.99sv-coco.com/">このサイトを出る</a>

<h1>数学科のための就活口コミサイト</h1>
<h3>トップページ</h3>

<ul>
<li><a href="mission_3_advice.php">数学科のためのなんでもアドバイス</a></li>
<li><a href="mission_3_keijiban.php">数学科なんでも掲示板</a></li>
</ul>

</body>
</html>
