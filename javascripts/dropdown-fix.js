jQuery(function($) {
    $('li.dropdown :first-child').on('click', function() {
        var $el = $(this).parent();
        if ($el.hasClass('open')) {
            var $a = $el.children('a.dropdown-toggle');
            if ($a.length && $a.attr('href')) {
                location.href = $a.attr('href');
            }
        }
    });
});