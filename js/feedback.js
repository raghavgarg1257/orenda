var main = function() {
			$('#img1').hover(function() {
				$('#img1 .img-cover').toggleClass('img-cover-opacity');
				$('#img1 .dev-media-links').toggleClass('link-on-hover');
				$('#img1 .description').toggleClass('decription-bg');
			});

			$('#img2').hover(function() {
				$('#img2 .img-cover').toggleClass('img-cover-opacity');
				$('#img2 .dev-media-links').toggleClass('link-on-hover');
				$('#img2 .description').toggleClass('decription-bg');
			});

			$('#img3').hover(function() {
				$('#img3 .img-cover').toggleClass('img-cover-opacity');
				$('#img3 .dev-media-links').toggleClass('link-on-hover');
				$('#img3 .description').toggleClass('decription-bg');
			});

			$('#img4').hover(function() {
				$('#img4 .img-cover').toggleClass('img-cover-opacity');
				$('#img4 .dev-media-links').toggleClass('link-on-hover');
				$('#img4 .description').toggleClass('decription-bg');
			});

			$('.feedback-btn').click(function() {
				$('.feedback-form').toggleClass('slide');
			});

			function remove() {
				$('.feedback-form').addClass('movein');
			}

			$('input.btn.btn-success').click(function() {
				$('.feedback-footer').addClass('slidein');
				setTimeout(remove, 2000);
			});
		}

		$(document).ready(main);