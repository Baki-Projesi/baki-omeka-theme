    </div>
    <footer id="footer-container" class="clearfix">
        <div id="footer-inner-container" class="clearfix">
            <div id="footer-logo" class="clearfix"> <a href="/"><img src="<?php echo img("nr-sm.png") ?>" alt="NR Small Logo"></a> </div>
            <div id="footer-content-container">
                <p class="sponsor-intro"><?php echo __('a collaboration of'); ?></p>
                <p class="sponsors"><a href="http://migration.unc.edu/">Latino Migration Project</a></p>
                <p class="sponsors"><a href="http://sohp.org/">Southern Oral History Program</a></p>
                <p class="sponsors"><a href="http://library.unc.edu/">University Libraries</a></p>
            </div>
            <div id="footer-unc-logo"> <a href="http://unc.edu"><img src="<?php echo img("unc-white.png") ?>" alt="The University of North Carolina at Chapel Hill"></a> </div>
            <div id="footer-bottom-wide">
                <p><a href="https://secure.dev.unc.edu/gift/Default.aspx?p=LMPU"><img class="support-button" alt="Support Us" src="<?php echo img("SupportUs-01.png"); ?>"></a></p>
                <p class="copyright">&copy; 2015 The University of North Carolina at Chapel Hill</p>
            </div>
        </div>
        <?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
    </footer>
    </div>
    <script type="text/javascript">
        jQuery(function($) {
            var lang_button = $('#header_bar li:last a');

            if($('html').attr('lang') === 'es') {
                lang_button.text('English');
            } else {
                lang_button.text('español');
            }
        });
    </script>
</body>
</html>
