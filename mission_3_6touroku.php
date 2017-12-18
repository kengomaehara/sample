<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数学科就活－新規登録</title>
</head>
<body>
<h1>新規登録</h1>

<form action="mission_3-6karitouroku.php" method="post">
  名前<br/>
 <input type="text" name="name" size="15" value="" /><br />
  メールアドレス<br/>
 <input type="text" name="address" size="50" value="" /><br />
  メールアドレス(確認)<br/>
 <input type="text" name="address2" size="50" value="" /><br />
  パスワード(8文字以上16文字以内)<br />
  <input type="password" name="password" size="16" maxlength="16" /><br />
  パスワード（確認）<br />
  <input type="password" name="password2" size="16" maxlength="16" /><br />
  <input type="submit" value="登録" /><br />
</form>

<form action="mission_3_main.php" method="post">
  <input type="submit" value="戻る" /><br />
</form>
<?php
?>
</body>
</html>
