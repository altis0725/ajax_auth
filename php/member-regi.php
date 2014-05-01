<?php
$regi_html = <<<REGI
<h1>メンバー登録</h1>
<form id="register" name="register">
<input id="salt" name="salt" value="${salt}" type="hidden">
<span>ユーザー名入力：</span>
<input id="username" name="username" size="32" type="text" style="ime-mode:disabled;"><br>
<span>パスワード入力：</span>
<input id="password" name="password" size="32" type="password"><br>
<span>パスワード確認：</span>
<input id="confirm" name="confirm" size="32" type="password"><br>
<input value="登録" type="submit">
</form>

REGI;
?>