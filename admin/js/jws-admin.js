(function($) {

	'use strict';

	jQuery(document).ready(function($) {

		var WPWC_Calculate = {

			init : function() {
				this.submit();
			},

			submit : function() {

				var self = this;

				$(document.body).on('submit', '.jws-calculate-statistics', function(e) {

					e.preventDefault();

					var submitButton = $(this).find( 'input[type="submit"]' );

					if ( ! submitButton.hasClass( 'button-disabled' ) ) {

						var data = $(this).serialize();

						submitButton.addClass( 'button-disabled' );
						$('.jws-progress-wrapper').remove();
						$(this).append( '<div class="jws-progress-wrapper"><span class="spinner is-active"></span><div class="jws-progress"><div></div></div></div>' );

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
						action: 'jws_calculate',
                        step: step,
					},
					dataType: "json",
					success: function(response) {

						if (response.step == 'done') {

							$(document.body).find('.notice').remove();

							var jws_calculate_form = $('.jws-calculate-statistics').find('.jws-progress').parent().parent();

							jws_calculate_form.find('.button-disabled').removeClass('button-disabled');
							jws_calculate_form.find('.spinner').remove();
							jws_calculate_form.find('.jws-progress').remove();
							jws_calculate_form.find('.jws-progress-wrapper').html(response.message);

							window.location.href = 'admin.php?page=just-writing-statistics';

						} else {

							$('.jws-progress div').animate({ width: response.percentage + '%' }, 50, function() { });
							self.process_step(parseInt(response.step), data, self);
						}

					}
				}).fail(function (response) {

					var jws_calculate_form = $('.jws-calculate-statistics').find('.jws-progress').parent().parent();

					jws_calculate_form.find('.button-disabled').removeClass('button-disabled');
					jws_calculate_form.find('.spinner').remove();
					jws_calculate_form.find('.jws-progress-wrapper').html('<b>Ajax call failed!<b><br>' + response.message);

					if (window.console && window.console.log) {

						console.log(response);
					}

				});

            },

		};

        WPWC_Calculate.init();

        // Calculate Writing Statistics Option
        $('input[name=jws_calculation_type]').change(function(){

            if ($(this).val() == 'dates') {

                $('#jws_calculation_by_dates').css('display', 'block');

            } else {

                $('#jws_calculation_by_dates').css('display', 'none');

            }

        });

        // jQuery UI Date Picker Initialization
        jQuery('.jws-datepicker').datepicker({

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

        $(".jws-datepicker").keypress(function(event) {event.preventDefault();});
        $('.jws-datepicker').change(function(){

            var date = $(this).datepicker('getDate');
            var id = $(this).attr('id') + '_formatted';

            $('#' + id).val($.datepicker.formatDate('yy-mm-dd', date));

            if ($(this).val() == '') {

                $('#' + id).val('');

            }

        });

	});

})(jQuery);