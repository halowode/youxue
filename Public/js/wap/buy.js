$(function() {
	$('.nav .list>li').mouseover(function() {
	//$(this).children('div').slideToggle(500);
		$(this).children('div').css('display','block');
	}).mouseout(function(){
		$(this).children('div').css('display','none');
		});
$.ajax({
	url:'http://123.56.73.211/index/getList',
	type:'post',
	dataType:'json',
	data:'',

});
