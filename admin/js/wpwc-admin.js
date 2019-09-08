(function($) {
	
	'use strict';

	jQuery(document).ready(function($) {
		
		var WPWC_Calculate = {
		
			init : function() {
				this.submit();
			},
	
			submit : function() {
	
				var self = this;
	
				$(document.body).on('submit', '.wpwc-calculate-statistics', function(e) {
					
					e.preventDefault();
	
					var submitButton = $(this).find( 'input[type="submit"]' );
	
					if ( ! submitButton.hasClass( 'button-disabled' ) ) {
	
						var data = $(this).serialize();
	
						submitButton.addClass( 'button-disabled' );
						$('.wpwc-progress-wrapper').remove();
						$(this).append( '<div class="wpwc-progress-wrapper"><span class="spinner is-active"></span><div class="wpwc-progress"><div></div></div></div>' );
	
						self.process_step( 1, data, self );
	
					}
	
				});
			},
	
			process_step : function(step, data, self) {
				
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						form: data,
						action: 'wpwc_calculate',
                        step: step,
					},
					dataType: "json",
					success: function(response) {
						
						if (response.step == 'done') {
							
							$(document.body).find('.notice').remove();
	
							var wpwc_calculate_form = $('.wpwc-calculate-statistics').find('.wpwc-progress').parent().parent();
	
							wpwc_calculate_form.find('.button-disabled').removeClass('button-disabled');
							wpwc_calculate_form.find('.spinner').remove();
							wpwc_calculate_form.find('.wpwc-progress').remove();
							wpwc_calculate_form.find('.wpwc-progress-wrapper').html(response.message);
	
						} else {
							
							$('.wpwc-progress div').animate({ width: response.percentage + '%' }, 50, function() { });
							self.process_step(parseInt(response.step), data, self);
						}
	
					}
				}).fail(function (response) {
					
					if (window.console && window.console.log) {
						
						console.log(response);
					}
					
				});
	
            },
		
		};
		
        WPWC_Calculate.init();

        // Calculate Word Counts Option
        $('input[name=wpwc_calculation_type]').change(function(){

            if ($(this).val() == 'dates') {
                
                $('#wpwc_calculation_by_dates').css('display', 'block');

            } else {
                
                $('#wpwc_calculation_by_dates').css('display', 'none');

            }

        });
        
        // jQuery UI Date Picker Initialization
        jQuery('.wpwc-datepicker').datepicker({

            dateFormat: 'MM d, yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onSelect: function(dateStr) {

                var date = $(this).datepicker('getDate');
                var id = $(this).attr('id') + '_formatted';

                $('#' + id).val($.datepicker.formatDate('yy-mm-dd', date));

            },

        });

        $(".wpwc-datepicker").keypress(function(event) {event.preventDefault();});
        $('.wpwc-datepicker').change(function(){

            var id = $(this).attr('id') + '_formatted';

            if ($(this).val() == '') {

                $('#' + id).val('');

            }

        });
		
	});
	
})(jQuery);