<?php function show_featured_img($css_class='', $page_id='', $wrapper_start=null, $wrapper_end=null) {
	global $post;
	if($page_id == '') {
		$page_id = $post->ID;
	}

	$description = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );

	if(has_post_thumbnail($page_id)) {
		if(isset($wrapper_start) && isset($wrapper_end)) {
			echo $wrapper_start;
		} ?>

		<picture <?php echo ($css_class !== '') ? 'class="'.$css_class.'"' : ''; ?>>
			<source srcset="<?php echo get_the_post_thumbnail_url($page_id); ?>" media="(min-width: 1280px)">
			<source srcset="<?php echo get_the_post_thumbnail_url($page_id, 'xlarge'); ?>" media="(min-width: 1024px)">
			<source srcset="<?php echo get_the_post_thumbnail_url($page_id, 'fp-large'); ?>" media="(min-width: 768px)">
			<img loading="lazy" src="<?php echo get_the_post_thumbnail_url($page_id, 'fp-small'); ?>" alt="<?php echo $description; ?>">
		</picture>

		<?php if(isset($wrapper_end) && isset($wrapper_start)) {
			echo $wrapper_end;
		}
	}
}