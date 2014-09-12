$('form').each(function(){
    $(this).submit(function(){
    var _username = $('input[name=u]').val();
	$('input[type=password]').each(function(){
	// TODO: MAKE IT  A Encrypt String
	var _pwd = $(this).val();
    var _ret = $.md5(_username + _pwd);
	});
	// return false;
    });
});
