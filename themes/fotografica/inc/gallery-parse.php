<?php

function sga_gallery_images( $size = 'large', $ids ) {
	global $post;

	$galleryimages = array();

	if ($ids) {
		$arrids = explode(',',$ids);
		if (is_array($arrids)) {
			foreach ($arrids as $id) {
				//$attimg   = wp_get_attachment_url($id,$size); // Anche _image va
				$attimg   = wp_get_attachment_image_src($id,$size,FALSE); // Anche _image va
				$attimg[] = $id; // slot 4 holds ID
				$attimg[] = get_post_field('post_excerpt', $id); // slot 5 holds caption
				$galleryimages[] = $attimg;
				// echo "<li>$id -  $attimg</li>\n";
			}
		}
	}

	return $galleryimages;
}


// Optimized code: gets plugin options only when called the first time
// $check_post_fields: defaults to FALSE. Set to TRUE if you would like to inspect the current posts' custom fields for gallery_type selection
function sga_get_options($check_post_fields=FALSE) {
	global $sga_options,$sga_gallery_types,$post;

	if (!is_array($sga_options)) {
		$sga_options = get_option('sga_options');
	}

	if ($check_post_fields && $post) {
		// If custom field 'gallery_type' is used, pick it to select gallery type
		if (($forced_type = get_post_meta($post->ID, 'gallery_type', true)) && $sga_gallery_types[$forced_type]) {
			$sga_options['sga_gallery_type'] = $forced_type;
		}
	}
}




add_filter('the_content', 'sga_contentfilter', 10);

function sga_contentfilter($content = '') {
	global $sga_gallery_types,$post,$sga_options,$sga_gallery_params;
	$post_id = $post->ID;
	$gallid = $post->ID;

	if (!(strpos($content,'[gallery')===FALSE)) {
		$howmany = preg_match_all('/\[gallery(\s+columns="[^"]*")?(\s+link="[^"]*")?\s+ids="([^"]*)"\]/',$content,$arrmatches);
		//echo "Post ID: $post_id - res: $res - Matches:".print_r($arrmatches,true);exit;

		if (!($gallery_type=get_post_meta($post_id, 'gallery_type', true))) { // Post/page's specific setting may override site-wide
			sga_get_options();
			$gallery_type = isset($sga_options['sga_gallery_type'])?$sga_options['sga_gallery_type']:NULL;
		}

		for ($gallid=0; $gallid<$howmany; $gallid++) {

			$gall = '';	// Reset gallery buffer
			//$gall = "gallery type: $gallery_type<br/>\n";

			$res = preg_match('/\s*columns="([0-9]+)"/',$arrmatches[1][$gallid],$arrcolmatch);
			$columns = 3;
			if (isset($arrcolmatch[1]) && intval($arrcolmatch[1])) $columns = intval($arrcolmatch[1]);

			$ids=$arrmatches[3][$gallid]; // gallery images IDs are here now

			$images = sga_gallery_images('full',$ids);
			$thumbs = sga_gallery_images('medium',$ids);

			// Safety check: if there are not settings for selected gallery type, just switch back to lightbox
			if (!in_array($gallery_type,array('lightbox','lightbox_labeled')) && !is_array($sga_gallery_params[$gallery_type])) $gallery_type='lightbox';

			if (count($images)) {

				switch ($gallery_type) {
				case 'lightbox':
				case 'lightbox_labeled':
				case '':


	$gall .= '
	<div id="gallery-'.$gallid.'" class="[ final-tiles-gallery gallery galleryid-'.$gallid.' ][ margin-bottom ]" data-gallery-number="'.$gallid.'"><div class="[ ftg-items ]">';

					for ($i=0;$i<count($thumbs);$i++) {
						$thumb = $thumbs[$i];
						$image = $images[$i];

						$gall .= '<div class="[ tile ]">
							<a class="[ tile-inner ]" href="'.$image[0].'"'.(($gallery_type == 'lightbox_labeled')?' title="'.$thumb[5].'"':'').' data-id="'.$image[4].'" data-number="'.$i.'" rel="gallery-'.$gallid.'"><img class="[ item ] attachment-thumbnail" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="'.$thumb[0].'" /></a>';
						$gall .= '</div>'."\n\n"; // title="'.print_r($thumb,true).'"
					}

					$gall .= '</div></div>';
				break;
				default:
					if (isset($sga_gallery_params[$gallery_type]) && ($hfunct = $sga_gallery_params[$gallery_type]['render_function'])) {
						if (function_exists($hfunct)) {
							if ($res = call_user_func($hfunct,$images,$thumbs,$post_id,$gallid)) { // If WP triggers an error here, you have an outdated addon plugin. A new param has been added in Simplest Gallery 2.5
								$gall .= "<!-- Rendered by {$sga_gallery_types[$gallery_type]} BEGIN -->\n";
								$gall .= $res;
								$gall .= "<!-- Rendered by {$sga_gallery_types[$gallery_type]} END -->\n";
							}
						}
					}
				} // Closes SWITCH

				$content = str_replace($arrmatches[0][$gallid],$gall,$content);
			} else {
				$gall .= 'Gallery is empty!';
				$content = str_replace($arrmatches[0][$gallid],$gall,$content);
			}
		} // Foreach loop on galleries
	}

	return $content;
}

function get_galleries_from_content($content = '') {
	global $post, $galleries;
	$post_id = $post->ID;
	$gallid = $post->ID;

	$galleries = array();

	$howmany = preg_match_all('/\[gallery(\s+columns="[^"]*")?(\s+link="[^"]*")?\s+ids="([^"]*)"\]/',$content,$arrmatches);
	for ($gallid=0; $gallid<$howmany; $gallid++) {

		$gall = '';	// Reset gallery buffer

		$res = preg_match('/\s*columns="([0-9]+)"/',$arrmatches[1][$gallid],$arrcolmatch);

		$ids = $arrmatches[3][$gallid]; // gallery images IDs are here now
		$images = sga_gallery_images('full',$ids);

		$galleries[] = $ids;

	} // Foreach loop on galleries

	return $galleries;
}