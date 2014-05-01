var server = window.location.protocol + "//" + window.location.host + window.location.pathname.replace("index.php","") +"php/";
$(function(){   
    var num = 0;
    $("#submit").click(function(){
        c=create(num);
        //alert(c);
        if(c == 0){
            num = 0;
            location.reload();
        }
    });
    
    $("#add").click(function(){
        num++;
        htmlwrite(num);
        //alert("ステータスを追加");       
    });
    
    $("#search").click(function(){
        search();       
    });
    
    $("#del").click(function(){
        if(num<=0){
            alert("ステータス無し");
        }else{
            del(num);
            num--;
            //alert("ステータスを削除");
        }
    });
});

function create(num){
    var item = check(num,"item");
    var re;
    if(item == -1){
        alert("形式を選択してください。");
        return error;
    }
    var geo = check(num,"geo");
    //alert(geo);
    if(geo == -1){
        alert("位置情報の有無を選択してください。");
        return error;
    }
    var status = sub(num);
    if(status == -1){
        alert("ステータスを記入してください。");
        return error;
    }
    if($("#hash").val() == ""){
        alert("ハッシュタグ名を記入してください。");
        return error;
    }
    if($("#conf").val() !== "true"){
        //alert($("#conf").val());
        alert("ハッシュタグの確認をしてください。");
        return error;
    }
    $.ajax({
        url: server + "action.php",
        type: "POST",
        cache: false,
        dataType: "text",
        async: false,
        data: {
            'status': status,
            'item': item,
            'hash': $("#hash").val(),
            'geo': geo
        },
        success: function(data){
            if(!data){
                alert("data not found");
                re = -1;
            }else{
                alert(data);
                reset();
                re = 0;
            }         
        },
        error: function(xhr, textStatus, errorThrown){
            alert('Error');
            re = -1;
        }
    });
    //alert("グループワーク作成完了！");
    return re;
}

function reset(){
    $("#contents").html("");
    $("#hash").val("");
}

function htmlwrite(data){
    var html = '<div id="con'+data+'">項目'+data+'<br>';
    html +='要素名<input type="text" id="status'+data+'" value=""><br>'
    html +='<input type="radio" name="item'+data+'" value="text" id="text'+data+'">'
    html +='<label for="text'+data+'">テキスト</label>'
    html +='<input type="radio" name="item'+data+'" value="image" id="image'+data+'">'
    html +='<label for="image'+data+'">画像</label><br><br></div>'
    $("#contents").append(html);
    
}

function del(data){
    $("#con"+data).remove();
}

function sub(num){
    var status = new Array(num);
       
    for(i=0;i<num;i++){
        if($("#status"+(i+1)).val() == ""){
            return -1;
        }else{
            status[i]=$("#status"+(i+1)).val();
        }
    }
    
    return status;
}

function search(){
    if($("#hash").val() == ""){
        alert("ハッシュタグ名を記入してください。");
        return error;
    }
    $.ajax({
        url: server + "search.php",
        type: "POST",
        cache: false,
        dataType: "text",
        data: {
            'hash': $("#hash").val()
        },
        success: function(data){
            if(!data){
                alert("Error:data not found");
            }else{
                alert(data);
                if(data == "OK"){
                    $("#result").html("ハッシュタグの確認完了！");
                    $("#conf").val("true");                   
                }else{
                    $("#result").html("このハッシュタグは使われています。");
                    $("#conf").val("false");
                }
                
            }         
        },
        error: function(xhr, textStatus, errorThrown){
            alert('Error');
        }
    });
}

function check(data,con){
    if(con === "item"){
        var item = new Array(data);

        for(i=0;i<data;i++){
            if(typeof $('input[name="'+con+(i+1)+'"]:checked').val() === "undefined"){
                return -1;
            }else{
                item[i] = $('input[name="'+con+(i+1)+'"]:checked').val();
            }
        }

        return item;
    }else if(con == "geo"){
        if(typeof $('input[name="'+con+'"]:checked').val() === "undefined"){
            return -1;
        }else{
            return $('input[name="'+con+'"]:checked').val();
        }
    }
}



        