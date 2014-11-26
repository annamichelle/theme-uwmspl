<?php 
queue_js_file('lightbox.min', 'javascripts/vendor');
queue_css_file('lightbox');
?>

<?php echo head(array('title' => metadata($item, array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<div class="return-nav">
    <?php echo return_to_exhibit(); ?>
</div>

<h1 class="item-title"><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h1>

<div id="primary">
    <!--  The following function prints all the the metadata associated with an item: Dublin Core, extra element sets, etc. See http://omeka.org/codex or the examples on items/browse for information on how to print only select metadata fields. -->
    <?php echo all_element_texts($item); ?>

    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

</div><!-- end primary -->

<div id="secondary">

    <!-- The following returns all of the files associated with an item. -->
    <?php if (metadata($item, 'has files')): ?>
    <div id="itemfiles" class="element">
        <h2>Files</h2>
        <div class="element-text"><?php echo item_image_gallery(array('link'=>array('data-lightbox'=>'lightbox'))); ?></div>
    </div>
    <?php endif; ?>

    <!-- The following prints a list of all tags associated with the item -->
    <?php if (metadata($item, 'has tags')): ?>
    <div id="item-tags" class="element">
        <h2>Tags</h2>
        <div class="element-text tags"><?php echo tag_string('item'); ?></div>
    </div>
    <?php endif; ?>

    <!-- If the item belongs to a collection, the following creates a link to that collection. -->
    <?php if (get_collection_for_item()): ?>
        <div id="collection" class="element">
            <h2>Collection</h2>
            <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
        </div>
    <?php endif; ?>

    <!-- The following prints a citation for this item. -->
    <div id="item-citation" class="element">
        <h2>Citation</h2>
        <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
    </div>

</div><!-- end secondary -->

<ul class="item-pagination navigation">
	<li><?php echo return_to_exhibit(); ?></li>
</ul>

<?php echo foot();
