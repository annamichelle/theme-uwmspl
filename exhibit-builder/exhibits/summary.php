<?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>

<div id="primary">
<h1><?php echo metadata('exhibit', 'title'); ?></h1>
<?php if (metadata('exhibit', 'subtitle')): ?>
    <h2><?php echo metadata('exhibit', 'subtitle'); ?></h2>
<?php endif; ?>

<?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
<div class="exhibit-description">
    <?php echo $exhibitDescription; ?>
</div>
<?php endif; ?>

<div class="continue-to-exhibit">
    <h2><?php echo cls_exhibit_link_to_first_page(); ?></h2>
</div>

<?php set_exhibit_pages_for_loop_by_exhibit(); ?>
<?php if (has_loop_records('exhibit_page') && get_theme_option('Exhibit Contents') !== 'none'): ?>
<div class="exhibit-contents">
	<h3><?php echo __('Contents'); ?></h3>
	<?php if (get_theme_option('Exhibit Contents') === accordion): ?>
    <div id="accordion">
        <?php foreach (loop('exhibit_page') as $exhibitPage): ?>
        <?php echo emiglio_exhibit_builder_summary_accordion($exhibitPage); ?>
        <?php endforeach; ?>
    </div>
	<?php else: ?>
	<div id="plain">
		<?php foreach (loop('exhibit_page') as $exhibitPage): ?>
		<?php echo emiglio_exhibit_builder_summary_plain($exhibitPage); ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
</div>

<div id="secondary">

<?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
<div class="exhibit-credits featured">
    <h2><?php echo __('Credits'); ?></h2>
    <p><?php echo $exhibitCredits; ?></p>
</div>
<?php endif; ?>
    
</div>

<?php echo foot(); ?>
