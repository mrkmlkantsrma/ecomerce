		$(document).ready(function(){
			//Vertical
			$('.scrollY').wrap('<div class="scrollY-container"></div>');
			$('.scrollY-container').append('<div class="scrollYbar"><div class="scrollY-but"></div></div>');
			$('.scrollY-container').css('width',function(){
				return $(this).children('.scrollY').width();
			});
			$('.scrollY-container').css('height',function(){
				return $(this).children('.scrollY').height();
			});
			$('.scrollY-but').css('height',function(){
				var $parent = $(this).parent();
				return Math.round(($parent.siblings('.scrollY').height()/$parent.siblings('.scrollY').prop('scrollHeight'))*$parent.height());
			});

			$('.scrollY-but').each(function(){
				if($(this).height()>$(this).parent().height()-2) $(this).parent().remove();
			});
			$('.scrollYbar').mousemove(function(e){
				var y = e.pageY - $(this).offset().top;
				if($(this).parent().height()-$(this).children('.scrollY-but').height()>=y){
					$(this).children('.scrollY-but').css({
						'top': y + 'px'
					});

					var $scrollTop = Math.round((y*$(this).siblings('.scrollY').height())/(($(this).siblings('.scrollY').height()/$(this).siblings('.scrollY').prop('scrollHeight'))*$(this).height()));
					$(this).siblings('.scrollY').scrollTop($scrollTop);
				}

			})
			//Horizontal
			$('.scrollX').each(function(){

				if($(this).hasClass('scrollY')){
					$(this).parent().addClass('scrollX-container');
				} else {
					$(this).wrap('<div class="scrollX-container"></div>');
				}
			})
			$('.scrollX-container').append('<div class="scrollXbar"><div class="scrollX-but"></div></div>');
			$('.scrollX-container').css('width',function(){
				return $(this).children('.scrollX').width();
			});
			$('.scrollX-container').css('width',function(){
				return $(this).children('.scrollX').width();
			});
			$('.scrollX-but').css('width',function(){
				var $parent = $(this).parent();
				return Math.round(($parent.siblings('.scrollX').width()/$parent.siblings('.scrollX').prop('scrollWidth'))*$parent.width());
			});
			$('.scrollX-but').each(function(){
				if($(this).width()==$(this).parent().width()) $(this).parent().remove();
			});

			$('.scrollXbar').mousemove(function(e){
				var y = e.pageX - $(this).offset().left;
				if($(this).parent().width()-$(this).children('.scrollX-but').width()>=y){
					$(this).children('.scrollX-but').css({
						'left': y + 'px'
					});

					var $scrollLeft = Math.round((y*$(this).siblings('.scrollX').width())/(($(this).siblings('.scrollX').width()/$(this).siblings('.scrollX').prop('scrollWidth'))*$(this).width()));
					$(this).siblings('.scrollX').scrollLeft($scrollLeft);
				}

			})
		});
