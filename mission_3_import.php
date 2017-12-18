<?php
 if ($_GET["id"]!="") {
  $id = $_GET["id"];

 $MIMETypes = array(
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4'
    );

$servername = "";
$username = "";
$password = "";
$dbname = "";
//接続
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $sql = "SELECT * FROM mission3_advice WHERE id = :id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":id", $id, PDO::PARAM_STR);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
mb_http_output("pass");   
     header("Content-Type: ".$MIMETypes[$row["type"]]);
        echo ($row["raw_data"]);}
