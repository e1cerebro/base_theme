<?php

/**
 * check whether the ACF Plugin is installed to prevent fatal PHP error
 *
 * @return boolean
 */
function isACFInstalled() {
	if (function_exists('get_field') || function_exists('the_field')) {
		return true;
	} else {
		return false;
	}
}

/**
 * show a link that's a part of an acf layout
 *
 * @param string $field_name: the name of the acf field or sub-field (of link type)
 * @param boolean $is_sub_field: true for a sub_field, false for a normal field
 * @param string $css_class: any additional css classes you want to add to the anchor tag
 * @param string $parent_page: the page where this field can be found; null for current page
 * 
 * @return void
 * 
 * @side-effects: outputs a string consisting of the html for displaying the link
 */
function show_acf_link($field_name, $is_sub_field=false, $css_class='', $parent_page=null){
	$link=null;
	if($parent_page===null){
		$link=($is_sub_field?get_sub_field($field_name):get_field($field_name));
	}else{
		$link=($is_sub_field?get_sub_field($field_name,$parent_page):get_field($field_name,$parent_page));
	}
	if(!empty($link)){ ?>
		<a href='<?php echo $link['url']; ?>' class='<?php echo $css_class; ?>' target='<?php echo $link['target']; ?>'>
			<?php echo $link['title']; ?>
		</a>
		<?php
	}
}

/**
 * Show the address based on the information entered on the theme settings page
 *
 * @param string $address
 * @param string $address_override
 * @param string $parent_page
 * 
 * @return void
 */
function show_acf_address($address = 'address', $address_override = 'address_override', $parent_page = 'option'){
	$address = get_field($address, $parent_page);
	$address_override = get_field($address_override, $parent_page);

	if($address_override){
		echo $address_override;
	}else{
		echo $address ? $address['street_number'].' '.$address['street_name'].'<br/>'
			.$address['city'].' '.$address['state'].'<br/>'.$address['post_code'] : "";
	}
}

// show_acf_img default options
define('ACF_DEFAULT_IMAGE_OPTIONS',array(
	'is_sub_field'=>false,
	'css_class'=>'',
	'parent_page'=>null,
	'wrapper_start'=>null,
	'wrapper_end'=>null,
));

/**
 * formats an acf image into a well optimized format for faster loading on the brow
 *
 * @param string $fieldname
 * @param array $option_array
 * 
 * @return void
 * 
 */
function show_acf_img($fieldname, $option_array=null) {
	global $post;

	//if no options are passed then use the defaults
	if($option_array===null){
		$option_array=ACF_DEFAULT_IMAGE_OPTIONS;
	//otherwise use the defaults as a base, but allow any options that are explicitly set to override that
	}else{
		$option_array=array_merge(ACF_DEFAULT_IMAGE_OPTIONS,$option_array);
	}

	$is_sub_field=$option_array['is_sub_field'];
	$css_class=$option_array['css_class'];
	$parent_page=$option_array['parent_page'];

	if(!$parent_page) {
		$parent_page = $post?->ID;
	}

	if($is_sub_field) {
		$img = get_sub_field($fieldname);
	} else {
		$img = get_field($fieldname, $parent_page);
	}

	$sizes = $img['sizes'] ?? null; 
	$description = $img['alt'] ?? null; ?>

	<?php if($sizes):
		if(isset($option_array['wrapper_start']) && isset($option_array['wrapper_end'])) {
			echo $option_array['wrapper_start'];
		} ?>

		<picture <?php echo ($css_class !== '') ? 'class="'.$css_class.'"' : ''; ?>>
			<source srcset="<?php echo $sizes['xlarge']; ?>" media="(min-width: 1280px)">
			<source srcset="<?php echo $sizes['fp-large']; ?>" media="(min-width: 1024px)">
			<source srcset="<?php echo $sizes['fp-medium']; ?>" media="(min-width: 768px)">
			<img loading="lazy" src="<?php echo $sizes['fp-small']; ?>" alt="<?php echo $description; ?>">
		</picture>

		<?php if(isset($option_array['wrapper_end']) && isset($option_array['wrapper_start'])) {
			echo $option_array['wrapper_end'];
		} ?>
	<?php endif; ?>
<?php }

/**
 * Simple function to add a prefix to an acf group name if there is one
 * used in template parts, when we pass in arguments
 *
 * @param string $prefix
 * @return void
 */
function add_acf_prefix($prefix){
	$pre='';
	if(!empty($prefix)){
		$pre = $prefix.'_';
	}
	return $pre;
}

//Acf video default query params
define('ACF_DEFAULT_VIDEO_PARAMS',array(
	'feature' => 'oembed',
	'controls' => 1,
	'hd' => 1,
	'enablejsapi' => 1,
	'rel' => 0,
));

/**
 * Returns a well formatted acf iframe element with additional params on the src
 *
 * @param string [required] $iframe: video iframe string
 * @param array [optional] $additional_attributes
 * @param array [optional] $additional_params: This is an optional associative array of additional params 'param' => value
 * 
 * @return void
 * 
 * @side-effects: outputs a string consisting of the html for displaying the iframe video
 */
function show_acf_video($iframe, $additional_attributes = null, $additional_params = null){
	if(!$iframe) return '';

	//merge the additional params with what we already have on the constant (ACF_DEFAULT_VIDEO_PARAMS) array
	$params = is_array($additional_params) ? array_merge(ACF_DEFAULT_VIDEO_PARAMS, $additional_params) : ACF_DEFAULT_VIDEO_PARAMS;

	//if the src attribute exists on the iframe then add the additional params to the iframe src
	if (preg_match('/src="(.+?)"/', $iframe, $matches)) {
		$src = $matches[1];
		$new_src = add_query_arg($params, $src);
		$iframe = str_replace($src, $new_src, $iframe);
	}

	//add additional attributes
	$attributes = '';
	if(is_array($additional_attributes) && count($additional_attributes) > 0){
		foreach($additional_attributes as $attribute_name => $attribute_value){
			$attributes .= " {$attribute_name} = '{$attribute_value}'";
		}
	}
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

	echo $iframe;
}

define('OLOT_DEFAULT_OPTIONS',array(
	'css_class' => 'wrapper',
	'acf_slug' => 'link',
	'tag_option' => 'div',
	'parent_page' => null,
	'is_sub_field' => true
));
function get_link_or_alternative_tags_array($option_array = array()): array {
	$option_array=array_merge(OLOT_DEFAULT_OPTIONS,$option_array);
	$css_class=$option_array['css_class'];
	$acf_slug=$option_array['acf_slug'];
	$tag_option=$option_array['tag_option'];
	$parent_page=$option_array['parent_page'];
	$is_sub_field=$option_array['is_sub_field'];
	$tag_array = array('opening_tag' => "<$tag_option>", 'closing_tag' => "</$tag_option>");

	$link = $is_sub_field ? get_sub_field($acf_slug, $parent_page) : get_field($acf_slug, $parent_page);
	$css_class .= !empty($link) ? ' has-link' : '';
	$tag = !empty($link) ? 'a' : $tag_option;
	$target = !empty($link) ? 'target="' . $link['target'] . '"' : '';
	$href = !empty($link) ? 'href="' . $link['url'] . '"' : '';

	$tag_array['opening_tag'] = sprintf('<%1$s %2$s %3$s class="%4$s">', $tag, $href, $target, $css_class);
	$tag_array['closing_tag'] = "</$tag>";

	return $tag_array;
}