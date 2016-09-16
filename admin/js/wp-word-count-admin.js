(function($) {
	
	'use strict';

	jQuery(document).ready(function($) {
		
		$('#wpwc-tabs').tabs();
		
		$('#wpwc-tabs a.nav-tab').click(function() {
			
			$('#wpwc-tabs a.nav-tab').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active');
			
		});
		
	});
	
})(jQuery);