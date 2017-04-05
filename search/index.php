<?php
    $pageTitle = __('Search Omeka ') . __('(%s total)', $total_results);
    echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
    $searchRecordTypes = get_search_record_types();
    $eng_esp = new NewRootsBilingual();
    $cookieData = $eng_esp->cookieData();
?>
    <h1><?php echo $pageTitle; ?></h1>
    <h5><?php echo search_filters(); ?></h5>
    <?php if ($total_results): ?>
        <ul class="list-unstyled" id="search-results">
            <?php $filter = new Zend_Filter_Word_CamelCaseToDash; ?>
            <?php foreach (loop('search_texts') as $searchText): ?>
            <?php $record = get_record_by_id($searchText['record_type'], $searchText['record_id']); ?>
            <?php $recordType = $searchText['record_type']; ?>
            <?php set_current_record($recordType, $record); ?>

            <li>
                <div class="col-sm-10 col-md-11">
                    <a class="search-results" href="<?php echo record_url($record, 'show'); ?>"><?php echo $eng_esp->invertName($searchText['title'] ? $searchText['title'] : '[Unknown]'); ?></a>
                    <?php $desc_field = $eng_esp->getField($cookieData, "Es: Resumen", "En: Abstract"); ?>
                    <?php //echo metadata('item', array('Dublin Core', 'Description'), array('snippet'=>350)); ?>
                    <p><?php echo metadata('item', array('Item Type Metadata', $desc_field), array('snippet'=>350)); ?></p>
                </div>
            </li>

            <?php endforeach; ?>
        </ul>
        <?php echo pagination_links(); ?>
    <?php else: ?>
        <p class="permalink"><?php echo __('Your query returned no results.');?></p>
    <?php endif; ?>
<?php echo foot(); ?>