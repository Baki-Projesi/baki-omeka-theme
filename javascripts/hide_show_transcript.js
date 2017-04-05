jQuery(function() {
    var transcript = jQuery('#transcript, #transcripcion');
    var transcript_button = jQuery('#transcript-button');

    transcript.addClass('hidden');

    transcript_button.click(function() {
        var current_text = jQuery(this).text(),
            new_text;
  
        if(transcript.hasClass('hidden')) {
            transcript.removeClass('hidden');
            new_text = (current_text === 'Show') ? 'Hide' : 'Esconder';
        } else {
            transcript.addClass('hidden');
            new_text = (current_text === 'Hide') ? 'Show' : 'Mostrar';
        }

        this.innerHTML = new_text;
    });
});