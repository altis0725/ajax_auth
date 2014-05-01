var server = window.location.protocol + "//" + window.location.host + window.location.pathname.replace("index.php","") +"php/";
$(function(){
    read();
    
    $("#del").click(function(){
        var item = check()
        if(item == -1){
            alert("データベースを選択してください。");
        return error;
        }
        del();
    });
    
    $("#con").click(function(){
        var item = check()
        if(item == -1){
            alert("データベースを選択してください。");
        return error;
        }
        con();
    });
    
    $("#get").click(function(){
        var item = check()
        if(item == -1){
            alert("データベースを選択してください。");
        return error;
        }
        get();
    });
    $("#create").click(function(){
        reset("#container");
        create();
    });
});

function read(){
    $.ajax({
        url: server + "read.php",
        type: "GET",
        cache: false,
        dataType: "json",
        success: function(data, status){
            if(data){
                for(var i=0;i<data.length;i++){
                    htmlwrite(data[i]);
                }
                //alert(data);
                //button();
            }else{
                alert('データベースがありません');
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            //alert("ほげ");
            alert(errorThrown);
        }       
    }); 
}

function del(){
    $.ajax({
        url: server + "delete.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: {
                table: $('input[name="database"]:checked').val()
            },
        success: function(data, status){
            if(data){
                alert('ok');
                reset("#contents");
                read();             
            }else{
                alert('データベースがありません');
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
        }       
    }); 
}

function con(){
    $.ajax({
        url: server + "con.php",
        type: "POST",
        cache: false,
        dataType: "text",
        data: {
                table: $('input[name="database"]:checked').val()
            },
        success: function(data, status){
            if(data){
                alert(data);
            }else{
                alert('non data');
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
        }       
    }); 
}

function get(){
    $.ajax({
        url: server + "get.php",
        type: "POST",
        cache: false,
        dataType: "text",
        data: {
                table: $('input[name="database"]:checked').val()
            },
        success: function(data, status){
            if(data){
                alert(data);
            }else{
                alert('non data');
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
        }       
    }); 
}

function create(){
    $.ajax({
        url: server + "create.php",
        type: "GET",
        dataType: "text",
        success: function(data, status){
            if(data){
                jQuery('#container').html(data);            
            }else{
                alert('データベースがありません');
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
        }       
    }); 
}

function check(){  
    if(typeof $('input[name="database"]:checked').val() === "undefined"){
        return -1;
    } 
    return 0;
}

function htmlwrite(data){
    var html = '<input type="radio" name="database" value="'+data+'" id="'+data+'">';
    html +='<label for="'+data+'">'+data+'</label><br>';
    $("#contents").append(html);
}

function reset(hash){
    $(hash).html("");
}
