(function ($) {
    "use strict";
    $(function () {

        $(document).on('widget-updated', function (event, widget) {
            var widget_id = $(widget).attr('id');
//            alert('On widget-updated: ' + widget_id);

            showCheckedLanguages();
            // any code that needs to be run when a widget gets updated goes here
            // widget_id holds the ID of the actual widget that got updated
            // be sure to only run the code if one of your widgets got updated
            // otherwise the code will be run when any widget is updated
        });

        $(document).on('widget-added', function (event, widget) {
            var widget_id = $(widget).attr('id');
//            alert('On widget-added: ' + widget_id);
            // any code that needs to be run when a new widget gets added goes here
            // widget_id holds the ID of the actual widget that got added
            // be sure to only run the code if one of your widgets got added
            // otherwise the code will be run when any widget is added
        });

        // Toggle(show/hide) hidden language elements(title, contactList)
        $(document).on('change', '.language_checkbox', function () {
            var languageHiddenElementClass = getLanguageHiddenElements(this);
            $('#' + languageHiddenElementClass).toggle("slow");
        });

        init();

        /**
         * Show checked languages
         * Activate tooltips
         * Activate tabs
         * @returns {undefined}
         */
        function init() {
            showCheckedLanguages();
            $('[data-toggle="tooltip"]').tooltip();
        }

        /**
         * Show the hidden elements of the checked languages
         * @returns {undefined}
         */
        function showCheckedLanguages() {
            $('.language_checkbox').each(function (index, value) {
                if (value.checked === true) {
                    var languageHiddenElementClass = getLanguageHiddenElements(value);
                    $('#' + languageHiddenElementClass).show();
                }
            });
        }

        /**
         * Get the id of the hidden elements of a specific language checkbox
         * @param {type} element
         * @returns {String}
         */
        function getLanguageHiddenElements(element) {
            var language = (element);
            var languageId = language.getAttribute('id');
            return 'hidden_' + languageId;
        }

    });
}(jQuery));