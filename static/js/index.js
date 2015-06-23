function dataAjax() {
  $.ajax({
    type: "post",
    url: "#",
    data: $('form').serialize(),
    dataType:'jsonp',
    success: function(data) {
      if (data.status)
          ajaxSuccess();
      }
    });
  ajaxSuccess();//改正确地址之后请删除此行
}
function ajaxSuccess() {
    document.getElementsByTagName('form')[0].style.display = 'none';
    $('.success').css('visibility', 'visible');
    $('.success').animate({
      'marginTop':'148px',
      'opacity':'1'
    });
}
function check() {  	
    var inputDOMS = document.getElementsByTagName('input');
    var formDOM = document.getElementsByTagName('form')[0];
    clearError();
    var ifFalse = false;
  	for (var i = 0; i <= 2; i++)
  		if (isNull(inputDOMS[i].value)) {
  			formDOM.getElementsByTagName('p')[2*i+1].style.visibility = 'visible';
  			ifFalse = true;
  		}
      if(ifFalse) return false;
  	if (isEmail(inputDOMS[2].value) || checkMobile(inputDOMS[2].value)) {
  		dataAjax();
  	} else {
      formDOM.getElementsByTagName('p')[6].style.visibility = 'visible';
  	}
    return false;
}
function clearError() {
    $('.error').css('visibility', 'hidden');
}
function isNull(str){ 
    if (str == "") return true; 
    var regu = "^[ ]+$"; 
    var re = new RegExp(regu); 
    return re.test(str); 
} 
function isEmail( str ){  
    var myReg = /^[-\._A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
    if(myReg.test(str)) return true; 
    return false; 
}
function checkMobile( s ){   
    var regu =/^[1][3,4,5,7,8][0-9]{9}$/; 
    var re = new RegExp(regu); 
    if (re.test(s)) { 
        return true; 
    }else{ 
        return false; 
    } 
}
