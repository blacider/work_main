function killerrors() {
        return true;
}
window.onerror = killerrors;

$(function () {

$.fn.hold = function(){
		var v = $(this).val();
		$(this).focus(function(){
			if($(this).val()==v){
				$(this).val('');
			}
		}).blur(function(){
			if($(this).val()=='') $(this).val(v);
		});
	}		   
$('.main_choose_search input.inp').hold();	
$('.main_choose_date input.date_1').hold();	
$('.main_choose_date input.date_2').hold();	
$('.main_choose_input input.inp_1').hold();	
$('.main_choose_input input.inp_2').hold();	

$(".menu a:not(.active)").hover(function(){
	$(this).addClass("active");
	},function(){	
	$(this).removeClass("active");
	})
	
	

$(".main_choose_check a").toggle(
         function(){
$(this).find("input").removeAttr("checked");},function(){
$(this).find("input").attr("checked",true);
		   });	

$(".pop_creat_hd span.close a,.pop_creat_ft a.btn").click(function(){
	$(".pop_creat").hide(100);
	$("#darkbg").hide(100);
	})

$("a.creatBtn_1,a.creatBtn_2,a.creatBtn_3").click(function(){
	$(".pop_creat").fadeIn(100);
	$("#darkbg").fadeIn(100);
	})

});

jQuery(function(){
//tab
function Tab(args){
	var tabMenu = args.tabMenu;
	var tabCont = args.tabCont;
	var evt = args.evt || 'click'
	tabMenu.eq(0).addClass('on');
	tabCont.eq(0).hide().siblings().show();
	tabMenu[evt](function(){
		var _this = jQuery(this);
		var _index = tabMenu.index(_this);
		_this.addClass('active').siblings().removeClass('active');
		tabCont.eq(_index).hide().siblings().show();
		return false;
	});
}


	
	new Tab({
			tabMenu : jQuery('.main_choose_nav_1 li'),
			tabCont : jQuery(''),
			evt     : 'click'
	});	
	
	new Tab({
			tabMenu : jQuery('.main_choose_nav_2 li'),
			tabCont : jQuery(''),
			evt     : 'click'
	});	
	
	
	
	 });  


$(".header_user").hover(function(){
    $(".header_user_pop").slideDown(100);
},function(){
    $(".header_user_pop").slideUp(100);
});
