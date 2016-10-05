var main = function() {
	
	$('.menu-icon').click(function() {
		$('.outer-links').toggleClass('open');
		$('.nav-header .brand').toggleClass('brand-toggle');
		$('.main-body').toggleClass('inner-toggle');
		$('.cover-element').toggleClass('show-hide');
		// $('.menu-icon .lines').toggleClass('bg-color');

	});
	

	var style1 = {
	  transform: "translateY(8px) rotate(45deg)",
	  transition: "transform 0.4s cubic-bezier(.25,.46,.45,.94)"
  };
			
  var style2 = {
    transform: "rotate(0deg)",
    transition: "transform 0.5s cubic-bezier(.25,.46,.45,.94)"
  };

  var style3 = {
    transform: "translateY(-8px) rotate(-45deg)",
    transition: "transform 0.4s cubic-bezier(.25,.46,.45,.94)"
  };

  var flag = 0;
      
	$('.menu-icon').click(function() {   
	  if($(this).attr('data-click-state') == 1) {
			$(this).attr('data-click-state', 0);
			flag=0;
			$('.line1').css(style2);
			$('.line3').css(style2);
			$('.line2').fadeTo("fast", 1);
			
			nav2.removeClass('nav-bg-color');
			nav1.removeClass('nav-bg-color');
			
		} 
		else {
				
				$(this).attr('data-click-state', 1)
				flag=1;
				$('.line1').css(style1);
				$('.line3').css(style3);
				$('.line2').fadeTo("fast", 0);
				nav2.addClass('nav-bg-color');
				nav1.addClass('nav-bg-color');
				// $(document).scroll(function() {
					
				// 	if(flag == 1) {
				// 	nav2.addClass('nav-bg-color');
				// 	nav1.addClass('nav-bg-color');
				//  }
				// });
			}
	});
       

	var nav1 = $('nav');
	var nav2 = $('.nav-header');
	var lastScroll = 0;
				
	$(document).on('scroll',function() {

		if($(this).scrollTop() != 0) {
			//	console.log($(this).scrollTop());
			// 		nav2.removeClass('nav-bg-color');
			// nav1.removeClass('nav-bg-color');
			// console.log($(document).scrollTop() + " " + lastScroll);
			$('.outer-links .links a').addClass('scroll');
			// $('.brand img').attr("src", "./img/logo2.png");
				}

				else {
			// 		nav2.addClass('nav-bg-color');
			// nav1.addClass('nav-bg-color');
			$('.outer-links .links a').removeClass('scroll');
			// $('.brand img').attr("src", "./img/logo2.png");
				}

		if($(this).scrollTop() > lastScroll && flag === 0) {
			nav2.addClass('abc');
			nav1.addClass('abc');
			
		}
		else {
			nav2.removeClass('abc');
			nav1.removeClass('abc');
			
		}
		lastScroll = $(this).scrollTop();
	
	});



	


	// var temp = 0;
	// if(temp == 0) {
	// 	$(this).click(function() {
	// 		temp = 1;
	// 		console.log(temp);
	// 		nav2.removeClass('nav-bg-color');
	// 			nav1.removeClass('nav-bg-color');
	// 		$(document).on('scroll',function() {
	// 			nav2.removeClass('nav-bg-color');
	// 			nav1.removeClass('nav-bg-color');
	// 		});
	// 	});
		
	// }

	

	// 	$('.menu-icon').click(function() {
	// 		console.log(temp);
	// 		if(temp == 1) {
	// 		nav2.addClass('nav-bg-color');
	// 		nav1.addClass('nav-bg-color');
	// 		temp = 0;
	// 	}
	// });

	// if($(document).scrollTop() != 0 && $('.menu-icon').attr("data-click-state") == 1)


	$(document).scroll(function() {
		if($(this).scrollTop() > 0) {
			$('.menu-icon .lines').addClass('bg-color2');
			
		}
		if($(this).scrollTop() == 0) {
			$('.menu-icon .lines').removeClass('bg-color2');
			
		}
	});




	if( $(window).width() < 768) {
			$('#signup').html("Sign Up");
		}

	$(window).resize(function() {
		if( $(window).width() < 768) {
			$('#signup').html("Sign Up");
		}
		else {
			$('#signup').html("Create free Account");
			if($('.main-body').hasClass('inner-toggle')) {
				$('.outer-links').removeClass('open');
				$('.nav-header .brand').removeClass('brand-toggle');
				$('.main-body').removeClass('inner-toggle');
				$('.menu-icon').attr('data-click-state', 0);
				$('.cover-element').removeClass('show-hide');
				// $('.menu-icon .lines').removeClass('bg-color');
				
				nav2.removeClass('nav-bg-color');
				nav1.removeClass('nav-bg-color');
			
				flag=0;
				$('.line1').css(style2);
				$('.line3').css(style2);
				$('.line2').fadeTo("fast", 1);
			}
		}
	});

};

$(document).ready(main);