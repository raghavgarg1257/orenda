function getin1() {
			$('.course1 .time-cover .border .arrow-head').toggleClass('arrow1');
			$('.course1 .time-cover .border .arrow-tail').toggleClass('arrow2');
		}

		function getin2() {
			$('.course2 .time-cover .border .arrow-head').toggleClass('arrow1');
			$('.course2 .time-cover .border .arrow-tail').toggleClass('arrow2');
		}

		function getin3() {
			$('.course3 .time-cover .border .arrow-head').toggleClass('arrow1');
			$('.course3 .time-cover .border .arrow-tail').toggleClass('arrow2');
		}

		var main1 = function() { 
			$('.course1 .time-cover').hover(function() {
				$('.course1 .time-cover .time').toggleClass('bg hover-shadow');
				$('.course1 .time p').toggleClass('show');
				$('.course1 .time-cover .border').toggleClass('enter-in');
				$('.course1.course .info').toggleClass('showup');
				if($('.course1 .info').hasClass('showup')) {
					$('.course1 .info p').css({"font-weight": "100"});
				}
				else {
					$('.course1 .info p').css({"font-weight": "700"});
				}
				setTimeout(getin1, 100);
			});

			$('.course2 .time-cover').hover(function() {
				$('.course2 .time-cover .time').toggleClass('bg hover-shadow');
				$('.course2 .time p').toggleClass('show');
				$('.course2 .time-cover .border').toggleClass('enter-in');
				$('.course2.course .info').toggleClass('showup');
				if($('.course2 .info').hasClass('showup')) {
					$('.course2 .info p').css({"font-weight": "100"});
				}
				else {
					$('.course2 .info p').css({"font-weight": "700"});
				}
				setTimeout(getin2, 100);
			});

			$('.course3 .time-cover').hover(function() {
				$('.course3 .time-cover .time').toggleClass('bg hover-shadow');
				$('.course3 .time p').toggleClass('show');
				$('.course3 .time-cover .border').toggleClass('enter-in');
				$('.course3.course .info').toggleClass('showup');
				if($('.course3 .info').hasClass('showup')) {
					$('.course3 .info p').css({"font-weight": "100"});
				}
				else {
					$('.course3 .info p').css({"font-weight": "700"});
				}
				setTimeout(getin3, 100);
			});
		}


		if($(window).width() > 767) {
			$(document).ready(main1);
		}

		$(window).resize(function() {
			if($(window).width() > 767) {
				$(document).ready(main1);
			}
		})