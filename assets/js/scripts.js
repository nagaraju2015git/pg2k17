$(window).load(function(){
   // Page Preloader
	$('#preloader').fadeOut('slow', function () {
		$(this).remove();
		$("body").css("overflow-y","auto");
	});
	
});

var owl = $('.owl-carousel').owlCarousel({
    loop: ($('.owl-carousel').children().length) > 1 ? false:true,
    nav: ($('.owl-carousel').children().length) > 1 ? false:true,
	dots:false,
	items:1,
	autoplay:true,
	autoplayTimeout:3000,
	/* animateIn: 'slideInRight',
	animateOut: 'slideOutLeft', */
	autoplayHoverPause: true,
	navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
})
var owl = $('.home_sections').owlCarousel({
    loop: ($('.home_sections').children().length) > 1 ? false:true,
    nav: ($('.home_sections').children().length) > 1 ? false:true,
	dots:false,
	items:4,
	margin:20,
	autoplay:true,
	autoplayTimeout:3000,
	autoplayHoverPause: true,
	navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsiveClass:true,
	responsive:{
		0:{
			items:2
		},
		600:{
			items:3
		},
		1000:{
			items:4
		}
	}
});
var owl = $('.reviews').owlCarousel({
    loop: ($('.reviews').children().length)==1 ? false:true,
    nav: ($('.reviews').children().length) > 1 ? false:true,
	dots:false,
	items:2,
	margin:20,
	autoplay:true,
	autoplayTimeout:3000,
	autoplayHoverPause: true,
	navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsiveClass:true,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:1
		},
		1000:{
			items:2
		}
	}
});

$(".dropdown.search_type").on("click",function(){
	if($(this).hasClass("active"))
		$(this).removeClass("active");
	else
		$(this).addClass("active");
});
$("#mh-view").on("click",function(){
	$("#m-header").removeClass("hide");
	$("body").css("overflow","hidden");
});
$("#ms-view").on("click",function(e){
	e.stopPropagation();
	$(".m-search").toggle("slow");
});
var screen_width = $(window).width();

$("body").on("click",function(){
	//alert(screen_width);
	/* if(screen_width < 767) {
		$(".m-search").css("display","none");
	} */
});
$(".m-search").on("click",function(e){
	e.stopPropagation();
});
$("span.toggle").on("click",function(){
	$(this).parent().find("ul.dropdown-list").toggle("slow");
});
$(document).ready(function(){
	$("#m-header").on("click",function(){
		$("#m-header").addClass("hide");
		$("body").css("overflow","auto");
	});
	$("#m-inner").on("click",function(e){
		e.stopPropagation();
	});
});

$("#m-filter").on("click",function(){
	$("#search-box").toggle("slow");
});
$(".dropdown.search_type a").on("click",function(e){
	e.preventDefault();
	$("#search_type").val($(this).data("value"));
	$("#search_type").trigger("change");
	$(".dropdown.search_type li").removeClass("active");
	$(this).parent().addClass("active");
});
$("#search_type").on("change",function(){
	if($("#search_type").val() == 'user')
		$("#key").attr("placeholder","Search User...");
	else
		$("#key").attr("placeholder","Search Gift & More...");
});
$(".pagination .disabled a").on("click",function(e){
	e.preventDefault();
});
$(document).ready(function(){
	$(".mbh").css("min-height",($(window).height()-166)+'px');
	$("footer").removeClass("hide");
});

