
$(document).ready(function(){
	//页面布局自动填充
	//alert(document.body.scrollHeight)
	
  //var BX = $("#Bottom").offset().top-135
  //var BY = $("#Bottom").offset().left-300;
  try{
  $(".ileft").css("height", $("#webfir").css("height"))//填充左边
  //填充背景线$("p").append("<b>Hello</b>");
  $("body").append("<div id=\"webbj\"></div>")
  $("#webbj").css("left",$("#webbody1").offset().left + "px").css("top","805px").css("height",document.body.scrollHeight-805+"px").show()
  //定位底
  $("#webBottom").css("left",$("#webbody1").offset().left + "px").css("top",document.body.scrollHeight-390 + "px").show()
  }catch(e){}
});
