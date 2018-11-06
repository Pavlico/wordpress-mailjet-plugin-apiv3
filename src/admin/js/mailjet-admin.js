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
    jQuery(document).ready(function ($) {

        $('.mailjet_row [scope=row]').closest('th').hide();

		function showExtraFromEmailInput($el) {
			if ($el.val() == undefined) {
				return;
			}
			if ($el.val().indexOf('*') >= 0) {
				var hiddenEmailExtra = $('#mailjet_from_email_extra_hidden').val();
				if (hiddenEmailExtra == undefined) {
                    hiddenEmailExtra = '';
				}
                $('<input style="margin-right:5px; width:150px; vertical-align: middle; " type="text" id="mailjet_from_email_extra" name="mailjet_from_email_extra" value="' + hiddenEmailExtra + '" required="required" placeholder="Enter your email name" />').insertBefore('#mailjet_from_email');
			} else {
                $('#mailjet_from_email_extra').remove();
			}
		};
		$('select[name="mailjet_from_email"]').change(function (e) {
			showExtraFromEmailInput($(this));
		});
		showExtraFromEmailInput($('select[name="mailjet_from_email"]'));


		// Show / Hide Sending options div
        $('.sending_options_div').hide();
        if($('input[name="mailjet_enabled"]').prop('checked') === true){
		   $('.sending_options_div').show();
       	}
        $('input[name="mailjet_enabled"]').click(function () {
            $('.sending_options_div').toggle('slow');
        });

        // Show / Hide Initial Sync options div
        $('.mailjet_sync_options_div').show();
        if($('input[name="activate_mailjet_sync"]').prop('checked') !== true){
            $('.mailjet_sync_options_div').hide();
            $('#activate_mailjet_initial_sync').prop('checked', false);
        }
        $('input[name="activate_mailjet_sync"]').click(function () {
            $('.mailjet_sync_options_div').toggle('slow');
            $('#activate_mailjet_initial_sync').prop('checked', $('input[name="activate_mailjet_sync"]').prop('checked'));
        });

        // Show / Hide Comment Authors Sync div
        $('.mailjet_sync_comment_authors_div').hide();
        if($('input[name="activate_mailjet_comment_authors_sync"]').prop('checked') === true){
            $('.mailjet_sync_comment_authors_div').show();
        }
        $('input[name="activate_mailjet_comment_authors_sync"]').click(function () {
            $('.mailjet_sync_comment_authors_div').toggle('slow');
        });


        // Send test email popup
        $(function() {
            $('#mailjet_test').on('click', function(event) {
                event.preventDefault();
                $('.pop').slideToggle('slow');
                $('#mailjet_test').hide();
                $('#enableSendingSubmit').hide();
                $('#cancelBtn').hide();
                return false;
            });

            $('.cancelTestEmail').on('click', function(event) {
                event.preventDefault();
                $('.pop').slideToggle('slow');
                $('#mailjet_test').show();
                $('#enableSendingSubmit').show();
                $('#cancelBtn').show();
                return false;
            });
        });


		// Create new Contact List popup
	   	$(function() {
            $('#create_contact_list').on('click', function(event) {
                event.preventDefault();
                $('.pop').slideToggle('slow');
                $('#create_contact_list').hide();
                $('#createContactListImg').hide();
                $('#initialContactListsSubmit').hide();
                return false;
            });
            $('.closeCreateList').on('click', function(event) {
                event.preventDefault();
                $('.pop').slideToggle('slow');
                $('#create_contact_list').show();
                $('#createContactListImg').show();
                $('#initialContactListsSubmit').show();
                return false;
            });

        });



        // Change settings menu links images on hover
        $('.settingsMenuLink a').hover(
            function(){
                $(this).addClass('hover');
                var imgId = $(this).data('img_id');
                if ($(this).parent().hasClass('settingsMenuLink1')) {
                    $('.' + imgId).css({fill:"#FFFFFF"});
                } else {
                    $('.' + imgId).css({fill:"#19BC9C"});
                }
            },
            function(){
                $(this).removeClass('hover');
                var imgId = $(this).data('img_id');
                if (!$(this).hasClass('active')) {
                    if ($(this).parent().hasClass('settingsMenuLink1')) {
                        $('.' + imgId).css({fill:"#FFFFFF"});
                    } else {
                        $('.' + imgId).css({fill:"#000000"});
                    }
                }
            }
        );


    });
})( jQuery );

function mjSelect() {
    const allSelects = document.querySelectorAll('.mj-select');
    allSelects.forEach(function(select) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('mj-select-wrapper');
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);
        const selectValue = () => select.querySelector("option:checked").textContent
        wrapper.setAttribute('data-value', selectValue());

        select.addEventListener("change", function() {
            wrapper.setAttribute('data-value', selectValue());
        });
        select.addEventListener("focus", function() {
            wrapper.classList.add('mj-select-focus');
        });
        select.addEventListener("blur", function() {
            wrapper.classList.remove('mj-select-focus');
        });
    });
}

document.addEventListener('readystatechange', event => {
    if (event.target.readyState === "complete") {
        mjSelect();
    }
});
