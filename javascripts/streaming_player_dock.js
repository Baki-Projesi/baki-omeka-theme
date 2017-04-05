jQuery(function() {
    var player = jQuery('#mediaspace'),
        admin_bar = jQuery('#admin-bar'),
        player_base = jQuery('#dublin-core-format'),
        nav_bar = jQuery('#primary-navigation');

    if(player.length) {
        var player_position = player.position();
        var win = jQuery(window);
        var width = win.innerWidth();
        var navbar_height = nav_bar.innerHeight();

        win.scroll(function() {
            var interviewee_div = function() {
                return jQuery('#name'); // Create closure so name stays in scope for all usages
            };
            var window_position = jQuery(this).scrollTop();
            var padding;

            if(window_position > player_position.top) {
                jQuery('#mediaspace div').css("display", 'inline-block');
                player.addClass('sticky');

                if(width > 750) {
                    padding = width/3;
                } else if (width > 500) {
                    padding = width/6;
                } else if( width > 350) {
                    padding = width/8;
                } else {
                    padding = "10px";
                }

                player.css({"padding-left": padding, top: navbar_height});
                admin_bar.css('margin-top', '65px');
                player_base.addClass('hide');
            } else {
                player.removeClass('sticky').css("padding-left", 0);
                admin_bar.css('margin-top', navbar_height);
                player_base.removeClass('hide');
            }

            if(!interviewee_div().length) {
                jQuery('<div id="name"></div>').appendTo('#mediaspace');

                var text_label = (jQuery('html').attr('lang') == 'es') ? 'Entrevistado/a: ' : 'Interviewee: ';
                var reversed_name = jQuery('#interviewee-name').text().split(',');
                var interviewee = reversed_name[1] + ' ' + reversed_name[0];

                interviewee_div().text(text_label + interviewee);
                if(jQuery("#mediaspace .audio-mpeg").length) {
                    interviewee_div().css('top', 0);
                }
            }
        });
    }
});