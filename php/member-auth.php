<?php
$auth_html = <<<AUTH
<h1>メンバー管理画面</h1>
<form id="ajax_regi" name="ajax_regi">
<input value="会員登録する" type="submit">
</form>

&nbsp;
<form id="ajax_auth" name="ajax_auth">
<input id="salt" name="salt" value="${salt}" type="hidden">
	ID:
<input id="username" name="username" size="32" type="text" style="ime-mode:disabled;"><br>
	PASSWORD：
<input id="password" name="password" size="32" type="password"><br>
<input value="送信する" type="submit">
</form>

AUTH;

?>