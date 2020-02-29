(function ($) {
 "use strict";

/*--------------------------
	Tooltip
---------------------------- */ 
	$('[data-toggle="tooltip"]').tooltip();
	
/*----------------------------
	jQuery MeanMenu
------------------------------ */
	jQuery('nav#dropdown').meanmenu();
	
/*----------------------------
	For Search Toggle
------------------------------ */
	$(".search-toggler").on('click', function(){
        $(".search-area").fadeToggle(1000);
    });
	$(".search-close").on('click', function(){
        $(".search-area").css("display","none");
    });
	
/*--------------------------
	For Sticky Menu
---------------------------- */	
	$(window).on('scroll', function(){
		if($(window).scrollTop()>50){
			$(".header-bottom").addClass('stick');
		}
		else{
			$(".header-bottom").removeClass('stick');
		}
	});
	
/*----------------------------
 owl active
------------------------------ */  
	$("#main-carousel").owlCarousel({
      autoPlay: true, 
	  slideSpeed:1000,
	  pagination:false,
	  navigation:true,	  
      singleItem:true,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	});

	$("#top-carousel").owlCarousel({
      autoPlay: false, 
	  slideSpeed:1000,
	  pagination:false,
	  navigation:true,  
      items : 3,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
      itemsDesktop : [1199,3],
	  itemsDesktopSmall : [980,3],
	  itemsTablet: [768,2],
	  itemsMobile : [479,1],
	  afterAction: function(el){
	  //remove class active
	  this.$owlItems.removeClass('active')
	  //add class active
	  this.$owlItems //owl internal $ object containing items
	  .eq(this.currentItem + 1).addClass('active')
	  }
	});

/*--------------------------
 scrollUp
---------------------------- */	
	$.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade',
		animationSpeed: 500
    }); 	   
 
})(jQuery); 