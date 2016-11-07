<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">x</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol> 
</div>


<script>

			var path = window.location.pathname;
			path = path.replace(/\/$/, "");
			path = decodeURIComponent(path);
		
			$(".nav a").each(function () {
				var href = $(this).attr('href');
				if (path.substring(0, href.length) === href) {
					$(this).closest('li').addClass('active');
				}
			});
							
			$(document).ready(function(){
				//Check to see if the window is top if not then display button
				$(window).scroll(function(){
					if ($(this).scrollTop() > 100) {
						$('.scrollToTop').fadeIn();
					} else {
						$('.scrollToTop').fadeOut();
					}
				});
				
				//Click event to scroll to top
				$('.scrollToTop').click(function(){
					$('html, body').animate({scrollTop : 0},800);
					return false;
				});
  			});



</script>


</body>
</html>