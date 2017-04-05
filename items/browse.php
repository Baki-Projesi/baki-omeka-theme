<?php
    $eng_esp = new NewRootsBilingual();
    $cookieData = $eng_esp->cookieData();
    $pageTitle = __('Browse Items');
    echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

    <h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>
    <?php echo item_search_filters(); ?>
    <?php $subnav = public_nav_items(); echo $subnav->setUlClass('nav nav-pills'); ?>

    <div class="browse-items">
        <?php if ($total_results > 0): ?>
        <?php
            $sortLinks[__('Title')] = 'Dublin Core,Title';
            $sortLinks[__('Creator')] = 'Dublin Core,Creator';
            ?>
        
            <?php foreach (loop('items') as $item): ?>
            <div class="item">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-offset-1 col-sm-offset-1">
                                <?php echo link_to_item($eng_esp->invertName(metadata('item', array('Item Type Metadata', 'Interviewee'))), array('class'=>'permalink')); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-md-1">
                                <?php $image = $item->Files; ?>
                                <?php if ($image) {
                                    echo link_to_item('<div style="background-image: url(' . file_display_url($image[0], 'original') . ');" class="img"></div>');
                                } else {
                                    echo link_to_item('<div style="background-image: url(' . img('defaultImage@2x.jpg') . ');" class="img"></div>');
                                } ?>
                            </div>
                            <div class="col-sm-10 col-md-11">
                                <?php $desc_field = $eng_esp->getField($cookieData, "Es: Resumen", "En: Abstract"); ?>
                                <?php //echo metadata('item', array('Dublin Core', 'Description'), array('snippet'=>350)); ?>
                                <?php echo metadata('item', array('Item Type Metadata', $desc_field), array('snippet'=>350)); ?>
                            </div>

                        </div>
                    </div>
                    <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>
                </div>
            </div>
            <?php endforeach; ?>
            <div id="outputs">
                <span class="outputs-label"><?php echo __('Output Formats'); ?></span>
                <?php echo output_format_list(false); ?>
            </div>
        <?php else : ?>
            <p class="browse-note"><?php echo $eng_esp->getField($cookieData, 'No hay productos que coincidan con la búsqueda', 'No Items Match the Search'); ?></p>
        <?php endif; ?>
    </div>
    <?php echo pagination_links(); ?>

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>
<?php echo foot(); ?>
