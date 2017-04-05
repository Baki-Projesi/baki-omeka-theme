jQuery(function($) {
    /**
     * Removes weird Omeka artifact where it says search field contains ""
     * Can't remove the whole field as it's needed for certain search types, such as many advanced searches
     */

    var search_terms = $('#item-filters .advanced');

    $.each(search_terms, function(data) {
        var self = $(this);

        if(/(contains|contiene)\s+""/.test(self.text())) {
           self.addClass('hide');
        }
    });
});