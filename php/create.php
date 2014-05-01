<?php
header('Content-Type: text/html; charset=utf-8');
$main_html = <<<MAIN

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/create-jquery.js" charset="utf-8"></script>
    <button id="add">ステータスの追加</button>
    <button id="del">ステータスの削除</button><br>
    <div id="contents"></div>
    位置情報<br>
    <input type="radio" name="geo" value="geo_on" id="geo_on"><label for="geo_on">あり(geoタグ)</label><br>
    <input type="radio" name="geo" value="geo_place" id="geo_place"><label for="geo_place">あり(placeタグ)</label><br>
    <input type="radio" name="geo" value="geo_tweet" id="geo_tweet"><label for="geo_tweet">あり(本文で入力)</label><br>
    <input type="radio" name="geo" value="geo_off" id="geo_off"><label for="geo_off">なし</label><br>
    ハッシュタグ名<input type="text" id="hash" value=""> <button id="search">検索</button><br>
    <div id="result"></div>
    <button id="submit">データベースの作成</button><br>
    <input type="hidden" id="conf" value="false">
    <a href="">データベースの確認</a>

MAIN;

echo $main_html;

?>