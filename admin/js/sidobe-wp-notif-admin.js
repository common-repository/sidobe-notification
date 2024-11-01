(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    // Handle change event for checkbox
  $( window ).load(function() {
    $('.sidobe-content-status').change(function() {
      $('#sidobe_loading_overlay').css('display', 'flex')

      var templateCode = $(this).attr('name');
      var templateStatus = $(this).is(':checked') ? 1 : 0;

      $.ajax({
        url: sidobe_ajax_obj.ajax_url,
        type: 'POST',
        data: {
            action: 'sidobe_ajax_status_action',
            nonce: sidobe_ajax_obj.nonce,
            template_status: templateStatus,
            template_code: templateCode
        },
        success: function(response) {
          if (!response.success) {
            alert('Failed update data !, please try again')
          }
          $('#sidobe_loading_overlay').css('display', 'none')
        },
        error: function(xhr, status, error) {
          alert('Failed update data !, please try again')
          $('#sidobe_loading_overlay').css('display', 'none')
        }
      });
    });
  });
})( jQuery );
