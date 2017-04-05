<?php
echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show'));
$eng_esp = new NewRootsBilingual();
$cookieData = $eng_esp->cookieData();
$link_regex = '/^(los\s+)?dat(a|o)/';
$display_elements = $eng_esp->displayElements($cookieData); //print_r($display_elements);
?>

    <div class="row">
            <div id="top-content-container" class="clearfix">
                <div id="interview-title" class="clearfix content-block">
                    <h1 id="interviewee-name"><?php echo $eng_esp->invertName($display_elements[0]['value']); ?></h1>
                </div>
                <div id="basic-metadata-container" class="clearfix content-block">
                    <h2 class="sr-only">Basic Interview Metadata</h2>
                    <div class="meta-left-col clearfix">
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"><?php echo $display_elements[0]['name']; ?><br>
                            </p>
                            <p class="metadata"><?php echo $eng_esp->invertName($display_elements[0]['value']); ?></p>
                        </div>
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"><?php echo $display_elements[12]['name']; ?><br>
                            </p>
                            <p class="metadata"> <?php echo $eng_esp->invertName($display_elements[12]['value']); ?></p>
                        </div>
                    </div>
                    <div class="meta-right-col clearfix">
                        <div class="metadata-container">
                            <p class="metadata-label"><?php echo $display_elements[1]['name']; ?><br />
                            </p>
                            <p class="metadata"> <?php echo $display_elements[1]['value']; ?></p>
                        </div>
                        <div class="metadata-container">
                            <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Idioma de la Entrevista', 'Language of Interview'); ?><br>
                            </p>
                            <p class="metadata">
                            <?php $languages = $eng_esp->displayThemes($display_elements[13]['value']); ?>
                            <?php foreach($languages as $language_search => $language):
                                if($language != '' && !preg_match($link_regex, strtolower($language))): ?>
                                <a href="../browse?search=<?php echo $language_search; ?>&advanced[0][element_id]=84&advanced[0][type]=contains&advanced[0][terms]=&range=&collection=&type=&user=&tags=&public=&featured=&exhibit=&geolocation-address=&geolocation-latitude=&geolocation-longitude=&geolocation-radius=10&submit_search=Search+for+items"><?php echo $language; ?></a>
                            <?php else: ?>
                                <?php echo $language; ?></a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content" class="clearfix">
                <h2 class="sr-only"><?php echo __('Interview Text and Audio'); ?></h2>
                <div id="abstract" class="content-block clearfix">
                    <h3> <?php echo $display_elements[9]['name'] ?></h3>
                    <?php echo $display_elements[9]['value']; ?>

                        <!-- This button is just styled and non functional. But it has responsive styles to clear the paragraph and become a full width button at smaller sizes. -->

                    </p>
                </div>
                <div id="player-container" class="clearfix content-block">
                <?php // DuracloudStreaming Plugin uses the Dublin Core "Format" field to store the Duracloud filename.
                      // If there is data in this field, display the html that the plugin needs to add a streaming player, unless it's restricted.
                      if (strlen(metadata('item', array('Dublin Core', 'Format'))) > 0 && !preg_match('/^closed/', strtolower($display_elements[10]['value']))): ?>
                        <div id='dublin-core-format' class='element'>
                            <div class='hide'><?php echo metadata('item', array('Dublin Core', 'Format')); ?></div>
                        </div>
                <?php endif; ?>
                </div>
                <?php $themes = $eng_esp->displayThemes($display_elements[5]['value']); ?>
                <div id="themes" class="content-block clearfix">
                    <h3><?php echo $display_elements[5]['name']; ?></h3>
                    <!-- This is flex-kit styled, I think it will break in early IE, but... my default styling I think will still work ok - floated inline-blocks that can shuffle in a limited way. -->
                    <ul id="themes-container">
                        <?php
                        foreach($themes as $theme_search => $theme):
                            if($theme != '' && !preg_match($link_regex, strtolower($theme))): ?>
                                <li><a class="interview-theme" href="../browse?search=<?php echo $theme_search; ?>&advanced[0][element_id]=84&advanced[0][type]=contains&advanced[0][terms]=&range=&collection=&type=&user=&tags=&public=&featured=&exhibit=&geolocation-address=&geolocation-latitude=&geolocation-longitude=&geolocation-radius=10&submit_search=Search+for+items"><?php echo $theme; ?></a></li>
                            <?php else: ?>
                                <li><?php echo $theme; ?></a></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="transcript-container" class="content-block clearfix">
                    <?php if(!preg_match('/^closed/', strtolower($display_elements[10]['value']))): ?>
                        <div id="transcript-heading" class="clearfix">
                            <h3><?php echo $display_elements[14]['name']; ?></h3>
                            <?php $button_text = ($display_elements[14]['name'] == 'Transcript') ? 'Show' : 'Mostrar'; ?>
                            <button type="button" class="showhide-control" id="transcript-button"><?php echo $button_text; ?></button>
                        </div>
                        <div id="transcript" class="clearfix">
                            <?php  ?>
                            <?php echo $display_elements[14]['value']; ?>
                        </div>
                    <?php endif; ?>
                </div>

        </div>
            <?php // echo all_element_texts('item'); ?>
            <div id="sidebar" class="clearfix">
                <div id="individual-map" class="clearfix">
                    <h3 class="sr-only"><?php echo __('Map of Journey'); ?></h3>
                </div>
                <div id="meta-primary" class="clearfix">
                    <div id="interviewee-data" class="content-block clearfix">
                        <div class="meta-top-section">
                            <div class="metadata-container">
                                <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Fecha de nacimiento del entrevistado/a', 'Interviewee Date of Birth'); ?></p>
                                <p class="metadata"><?php echo $display_elements[11]['value']; ?></p>
                            </div>
                            <div class="metadata-container">
                                <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Lugar de origen del entrevistado/a', 'Interviewee Place of Origin'); ?></p>
                                <p class="metadata"><?php echo $display_elements[2]['value'] ?></p>
                            </div>
                            <div class="metadata-container hidden">
                                <p class="metadata-label"><?php echo $display_elements[4]['name']; ?></p>
                                <p id="interviewee-journey-coordinates" class="metadata"><?php echo $display_elements[4]['value']; ?></p>
                            </div>
                        </div>
                        <div class="meta-bottom-section">
                            <div class="metadata-container">
                                <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Lugares de residencia del entrevistado/a', 'Interviewee Places of Residence'); ?></p>
                                <p class="metadata"><?php echo $display_elements[3]['value']; ?></p>
                            </div>
                            <div class="metadata-container">
                                <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Género de entrevistado/a', 'Interviewee Gender'); ?></p>
                                <p class="metadata"><?php echo $display_elements[6]['value'] ?></p>
                            </div>
                            <div class="metadata-container">
                                <p class="metadata-label"><?php echo $eng_esp->getField($cookieData, 'Ocupación del entrevistado/a', 'Interviewee Occupation'); ?></p>
                                <p class="metadata">
                                    <?php $occupations = $eng_esp->displayThemes($display_elements[7]['value']); ?>
                                    <?php foreach($occupations as $occupation_search => $occupation):
                                        if($occupation != '' && !preg_match($link_regex, strtolower($occupation))): ?>
                                        <a href="../browse?search=<?php echo $occupation_search; ?>&advanced[0][element_id]=84&advanced[0][type]=contains&advanced[0][terms]=&range=&collection=&type=&user=&tags=&public=&featured=&exhibit=&geolocation-address=&geolocation-latitude=&geolocation-longitude=&geolocation-radius=10&submit_search=Search+for+items"><?php echo $occupation; ?></a>
                                    <?php else: ?>
                                        <?php echo $occupation; ?></a></li>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div id="lower-content" class="clearfix">
                <div id="view-pdf" class="clearfix content-block">

              <?php if (get_theme_option('Item FileGallery') == 0 && metadata('item', 'has files')):
                    $pdf_text = $eng_esp->getField($cookieData, "Ver Transcripción y Todos los Materiales", "View Transcript &amp; All Materials");
                    $audio_text = $eng_esp->getField($cookieData, "Descarga de Audio", "Download Audio"); ?>
                    <div class="downloads"><a class="download-button" href="<?php echo $eng_esp->getDownloadFiles($item->Files) ?>"><?php echo $pdf_text; ?></a></div>
                    <div class="downloads"><a class="download-button" href="<?php echo $eng_esp->getDownloadFiles($item->Files, false) ?>"><?php echo $audio_text; ?></a></div>
              <?php endif; ?>

                </div>
                <div id="meta-secondary" class="clearfix content-block">
                    <div class="meta-left-col clearfix">
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"> <?php echo $display_elements[8]['name']; ?><br />
                            </p>
                            <p class="metadata"> <?php echo $display_elements[8]['value']; ?> </p>
                        </div>
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"> <?php echo $display_elements[10]['name'] ?><br />
                            </p>
                            <p class="metadata"><?php echo $display_elements[10]['value'] ?></p>
                        </div>
                    </div>
                    <div class="meta-right-col clearfix">
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"> <?php echo $eng_esp->getField($cookieData, 'URL de Referencia', 'Reference URL'); ?><br />
                            </p>
                            <p class="metadata urlwrap"> <a href="<?php echo metadata('item', array('Item Type Metadata', 'Reference URL')); ?>"><?php echo metadata('item', array('Item Type Metadata', 'Reference URL')); ?></a></p>
                        </div>
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"> <?php echo $display_elements[17]['name']; ?><br />
                            </p>
                            <p class="metadata"> <?php echo $display_elements[17]['value']; ?> </p>
                        </div>
                    </div>
                    <div class="meta-span-two-col clearfix">
                        <div class="metadata-container clearfix">
                            <p class="metadata-label"> <?php echo $eng_esp->getField($cookieData, 'Referencia', 'Citation'); ?><br />
                            </p>
                            <?php $cite_language = $eng_esp->getField($cookieData, 'Es: Citación', 'En: Citation'); ?>
                            <p class="metadata cite"> <?php echo metadata('item', array('Item Type Metadata', $cite_language)); ?> </p>
                        </div>
                    </div>
                </div>

                <!-- The following returns all of the files associated with an item. -->
                <?php if (metadata('item', 'has files')): ?>
                    <div id="itemfiles" class="element hide">
                        <div class="element-text"><?php echo files_for_item(); ?></div>
                    </div>
                <?php endif; ?>
        </div>
    </div>
<?php //endforeach; ?>
    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>
    <ul class="pager">
        <li class="previous"><?php echo link_to_previous_item_show(); ?></li>
        <li class="next"><?php echo link_to_next_item_show(); ?></li>
    </ul>

<?php echo foot(); ?>
