if (typeof jQuery !== 'undefined') {
	/* ダイアログ（jQuery UI）初期化 */
	var dialog = jQuery('#dialog');
    var server = window.location.protocol + "//" + window.location.host + window.location.pathname.replace("index.php","") +"php/";
    dialog.dialog({
		autoOpen: false,
		modal: true,
		title: 'メッセージ確認',
		position: 'center',
		minWidth: 400,
		width: 200
	});
	/* 認証開始メソッド初期化 */
	function authorize() {
        //$("#container").html("");
        //Get_Url("http://localhost/ajax_auth/php/member-auth-ajax.php","#container");
        
		var form = jQuery('#ajax_auth'),
			user = form.find('input[type=text]'),
			salt = form.find('input[type=hidden]'),
			pass = form.find('input[type=password]'),
			regi = jQuery('#ajax_regi'),
			url = server + 'auth.php';
		/* 認証フォーム */
		form.submit(function (event) {
			var query;
			event.preventDefault();
			if (user.val() === '' || pass.val() === '') {
				dialog.dialog('open').html('ユーザー名かパスワードが入力されていません。');
				pass.val('');
				return;
			} else if( user.val().match( /[^A-Za-z0-9\s]+/ ) ) {
                dialog.dialog('open').html('ユーザー名は半角英数字で入力してください。');
                return;
            } 

			pass.val(CybozuLabs.SHA1.calc(salt.val() + CybozuLabs.SHA1.calc(pass.val())));

			query = url + '?' + jQuery(this).serialize();
			pass.val('');
			jQuery.get(
				query,
				null,
				function (data) {
					if (/^failed$/.test(data)) {
						dialog.dialog('open').html('IDかパスワードが間違っています。');
					} else if (/^expired$/.test(data)) {
						dialog.dialog('open').html('ログイン有効期限が過ぎました。リロードしてやり直してください。');
					} else if (/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi.test(data)) {
						dialog.dialog('open').html('ログインに成功しました。');
						/* イベントハンドラを削除して要素を入れ替える */
						form.unbind('submit');
						jQuery('#container').html(data);
						logout();
					}
				},
				'html'
			);
		});
		/* 登録ボタン */
		regi.submit(function (event) {
			var url = server + 'pager.php';
            
			event.preventDefault();

			jQuery.get(
				url,
				{
					page: 'register'
				},
				function (data) {
					if (/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi.test(data)) {
						regi.unbind('submit');
						jQuery('#container').html(data);
						register();
					}
				},
				'html'
			);
		});
	}
	/* ログアウト開始メソッド初期化 */
	function logout() {
        //$("#container").html("");
        //Get_Url("http://localhost/ajax_auth/php/member-main-ajax.php","#container");
        
		var form = jQuery('#member'),
        url = server + 'logout.php';

		form.submit(function (event) {
			var query = url + '?' + jQuery(this).serialize();
			event.preventDefault();

			jQuery.get(
				query,
				null,
				function (data) {
					dialog.dialog('open').html('ログアウトしました。');
					form.unbind('submit');
					jQuery('#container').html(data);
					authorize();
				},
				'html'
			);
		});
	}
	/* 登録開始メソッド初期化 */
	function register() {
		var form = jQuery('#register'),
			user = form.find('input[type=text]'),
			pass = form.find('input#password'),
			conf = form.find('input#confirm'),
			url = server + 'regi.php';

		form.submit(function (event) {
			var query;
			event.preventDefault();

			if (user.val() === '') {
				dialog.dialog('open').html('ユーザー名を入力してください。');
				return;
			} else if( user.val().match( /[^A-Za-z0-9\s]+/ ) ) {
                dialog.dialog('open').html('ユーザー名は半角英数字で入力してください。');
                return;
            } else if (pass.val() !== conf.val()) {
				dialog.dialog('open').html('パスワードが一致しません。再入力をお願いします。');
				pass.val('');
				conf.val('');
				return;
			} else if (pass.val() === ''){
                dialog.dialog('open').html('パスワードを入力してください。');
				return;
            }
            
            pass.val(CybozuLabs.SHA1.calc(pass.val()));
            conf.val(CybozuLabs.SHA1.calc(conf.val())); 

			query = url + '?' + jQuery(this).serialize();
			pass.val('');
			conf.val('');
			jQuery.get(
				query,
				null,
				function (data) {
					if (/^failed$/.test(data)) {
						dialog.dialog('open').html('登録に失敗しました。');
					} else if (/^duplicated$/.test(data)) {
						dialog.dialog('open').html('そのユーザーIDはすでに使用されています。');
					} else if (/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi.test(data)) {
						dialog.dialog('open').html('登録が完了しました。ユーザーIDとパスワードを忘れないようにしてください。');
						form.unbind('submit');
						jQuery('#container').html(data);
						logout();
					}
				},
				'html'
			);
		});
	}
    
    function pop() {
        event.preventDefault();
        dialog.dialog('open').html('ログイン有効期限が過ぎました。ログアウトします。');
    }
    
    function Get_Url(url,hash){
        alert(url);
        $.ajax({
        url: url,
        type: "GET",
        dataType: "text",
        success: function(data, status){
            if(data){
                $(hash).html(data);
            }       
        },
        error: function(xhr, textStatus, errorThrown){
            alert('Error');
        }       
    }); 
    }
}