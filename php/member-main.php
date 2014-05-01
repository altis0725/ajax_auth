<?php
$main_html = <<<MAIN
<h1 id="title">ホームページ</h1>
<h2>こんにちは${user}さん</h2>
<h1>メニュー</h1>
<h1>コンテンツ</h1>
<form id="member" name="member">
<input id="param" name="param" value="logout" type="hidden">
<input value="ログアウト" type="submit">
</form>

MAIN;

$main_html = <<<MAIN
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/check-jquery.js" charset="utf-8"></script>
こんにちは{$user}さん。<br><br>
データベースの選択<br>
<div id="contents"></div><br>
<button id="del">グループワークの削除</button><br>
<button id="con">グループワークの内容の確認</button><br>
<button id="get">グループワークの内容の詳細</button><br>
<button id="create">グループワークの新規作成</button><br>
<form id="member" name="member">
<input id="param" name="param" value="logout" type="hidden">
<input value="ログアウト" type="submit">
</form>

MAIN;





?>