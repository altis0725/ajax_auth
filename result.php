<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>結果表示</title>
        <style type="text/css">
            body {
                margin:0;
                padding:0;
                }
            #map {
                position:absolute;
                width:100%;
                height:100%;
                left:0%;
                top:0%;
                }
        </style>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    </head>
    <body onload="initialize()">
        <?php            
            if(!isset($_GET['name']) or !isset($_GET['server'])) {
                echo "Error";            
            }else {              
                $server = $_GET['server'];
                $name = $_GET['name'];
                $geo = $_GET['geo'];
                $html = <<<MAIN
                
                <div id="map"></div>
                <div id="contents"></div>
                <input type="hidden" id="name" value="{$name}">
                <input type="hidden" id="server" value="{$server}">
                <input type="hidden" id="geo" value="{$geo}">
MAIN;
                echo $html;
                echo PHP_EOL;
            }
        //if($_GET['geo'] === "geo" || $_GET['geo'] === "place" || $_GET['geo'] === "tweet")

        ?>
    </body>
</html>