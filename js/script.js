var server = window.location.protocol + "//" + window.location.host + window.location.pathname.replace("result.php","") +"php/";
function initialize() {
    var data = getdata();
    var i;
    if($("#geo").val()){
        var latlng = new google.maps.LatLng(35.361056,138.731918);
        var opts = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), opts);




        //alert(server);
        //data.push({lat:'35.681382',lng:'139.766084',con:'東京駅'});
    
        for(i=0;i<data.length;i++){
            setMark(data[i], map);
        }
    }else{
        for(i=0;i<data.length;i++){
            sethtml(data[i]);
        }
    }
    //detectBrowser();
    
}

function setMark(data,map){
    if($("#geo").val() == "geo"){
        var latlng = data.geo.split(",");
        var lat = latlng[0];
        var lng = latlng[1];
        mark(data,map,lat,lng);
        
    }else if($("#geo").val() == "place" || $("#geo").val() == "tweet"){
        getLatLng(data,map,data.geo);
    }
}

function sethtml(data){
    var str = "";
    for (var key in data) {
        if(key !== "twTime" && key !== "twID"){
            //str += key + ": " + data[key] + "<br>";
            str += data[key] + "<br>";
        }       
    }
    var html = 
        "<table><tr><td colspan='2'>" 
        + str 
        + "</td></tr><tr><td>" 
        + data["twTime"] 
        + "</td><td>" 
        + "@" + data["twID"] 
        + "</td></tr></table>";
    $("#contents").prepend(html);
}

function mark(data,map,lat,lng){
    var str = "";
    for (var key in data) {
        /*
        if(key == "geo"){
            if($("#geo").val() == "geo"){
                var latlng = data.geo.split(",");
                var lat = latlng[0];
                var lng = latlng[1];
            }else if($("#geo").val() == "place" || $("#geo").val() == "tweet"){
                alert("34");
                latlng = getLatLng(data.geo);
                lat = latlng.lat();
                lng = latlng.lng();
                alert("38");
            }
        }else*/
        if(key !== "twTime" && key !== "twID" && key !== "geo"){
            //str += key + ": " + data[key] + "<br>";
            str += data[key] + "<br>";
        }       
    }
    var html = 
        "<table style='font-size:13px'><tr><td colspan='2'>" 
        + str 
        + "</td></tr><tr><td>" 
        + data["twTime"] 
        + "</td><td>" 
        + "@" + data["twID"] 
        + "</td></tr></table>";
    var iw_latlng = new google.maps.LatLng(lat, lng);
    var infowindow = new google.maps.InfoWindow({
        content: html,
        position: iw_latlng
    });

    infowindow.open(map);     
}

function detectBrowser() {
  var useragent = navigator.userAgent;
  var mapdiv = document.getElementById("map");
    
  if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
    mapdiv.style.width = '100%';
    mapdiv.style.height = '100%';
  } else {
    mapdiv.style.width = '100%';
    mapdiv.style.height = '100%';
  }
}

function getdata(){
    var datas;
    $.ajax({
        url: server + "func.php",
        type: "POST",
        cache: false,
        dataType: "json",
        async: false,
        data: {
            'name': $("#name").val(),
            'server': $("#server").val()
        },
        success: function(data){
            if(!data || data == ""){
                alert("data not found");
            }else{
                datas = data;
                //alert(data);
            }         
        },
        error: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
        }
    });
    
    //alert(datas[0].geo);
    
    return datas;
}

function getLatLng(data,map,place) {

  // ジオコーダのコンストラクタ
  var geocoder = new google.maps.Geocoder();
  var latlng;
  // geocodeリクエストを実行。
  // 第１引数はGeocoderRequest。住所⇒緯度経度座標の変換時はaddressプロパティを入れればOK。
  // 第２引数はコールバック関数。
  //alert("113");
  geocoder.geocode({
    address: place
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        latlng = results[0].geometry.location;
        mark(data,map,latlng.lat(),latlng.lng());
    } else if (status == google.maps.GeocoderStatus.ERROR) {
      alert("サーバとの通信時に何らかのエラーが発生！");
    } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
      alert("リクエストに問題アリ！geocode()に渡すGeocoderRequestを確認せよ！！");
    } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
      alert("短時間にクエリを送りすぎ！落ち着いて！！");
    } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
      alert("このページではジオコーダの利用が許可されていない！・・・なぜ！？");
    } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
      alert("サーバ側でなんらかのトラブルが発生した模様。再挑戦されたし。");
    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
      alert(place+"が見つかりません");
    } else {
      alert("えぇ～っと・・、バージョンアップ？");
    }
  });
  return latlng;
}
