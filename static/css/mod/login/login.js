$(document).ready(function(){
  $(".icon_close").hover(function(){
    $(".icon_close").attr("src","/static/img/mod/login/closed.png");
    $(".icon_close").attr("width","53");
    $(".icon_close").css("right","-16px");
    $(".icon_close").css("top","-13px");
    },function(){
    $(".icon_close").attr("src","/static/img/mod/login/close.png");
    $(".icon_close").attr("width","22");
    $(".icon_close").css("right","0px");
    $(".icon_close").css("top","0px");
  }); 
  $(".rightd").hover(function(){
    $(".rightd").attr("src","/static/img/mod/login/rightd.png");
    $(".rightd").attr("width","53");
    $(".rightd").attr("height","53");
    $(".rightd").css("top","-14px");
    $(".bottom-line").css("margin-top","32px");
    },function(){
    $(".rightd").attr("src","/static/img/mod/login/right.png");
    $(".rightd").attr("width","27");
    $(".rightd").attr("height","25");
    $(".rightd").css("top","0");
    $(".bottom-line").css("margin-top","60px");
  }); 
  $("#email-after").modal('show');
  
});

function checkUser() {
    var user = $("#login input[name='user']").val();
    if (user != '') {
        $("#login").modal('hide');
        $("#password").modal('show');
    }
}
function changeVisibility(dom) {
    var inputDom = dom.find('input');
    var imgDom = dom.find("img");
    if (inputDom.attr('type') == 'password') {
        inputDom.attr('type', 'text');
        imgDom.attr('src', '/static/img/mod/login/eyed.png');
    } else {
        inputDom.attr('type', 'password');
        imgDom.attr('src', '/static/img/mod/login/eye.png');
    }
}
function checkPhone() {

}
function checkEmail() {

}
function checkAfterEmail() {

}
function checkAfterPhone() {

}