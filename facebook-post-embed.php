<?php
/*
Plugin Name: Facebook Post Embed
Plugin URI: http://wp-time.com/facebook-post-embed/
Description: One shortcode to embedding facebook posts easily, responsive and custom margin bottom.
Version: 1.5
Author: Qassim Hassan
Author URI: http://qass.im
License: GPLv2 or later
*/

/*  Copyright 2015 Qassim Hassan (email: qassim.pay@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// WP Time Page
if( !function_exists('WP_Time_Ghozylab_Aff') ) {
	function WP_Time_Ghozylab_Aff() {
		add_menu_page( 'WP Time', 'WP Time', 'update_core', 'WP_Time_Ghozylab_Aff', 'WP_Time_Ghozylab_Aff_Page');
		function WP_Time_Ghozylab_Aff_Page() {
			?>
            	<div class="wrap">
                	<h2>WP Time</h2>
                    
					<div class="tool-box">
                		<h3 class="title">Thanks for using our plugins!</h3>
                    	<p>For more plugins, please visit <a href="http://wp-time.com" target="_blank">WP Time Website</a> and <a href="https://profiles.wordpress.org/qassimdev/#content-plugins" target="_blank">WP Time profile on WordPress</a>.</p>
                        <p>For contact or support, please visit <a href="http://wp-time.com/contact/" target="_blank">WP Time Contact Page</a>.</p>
					</div>
                    
            	<div class="tool-box">
					<h3 class="title">Recommended Links</h3>
					<p>Get collection of 87 WordPress themes for $69 only, a lot of features and free support! <a href="http://j.mp/ET_WPTime_ref_pl" target="_blank">Get it now</a>.</p>
					<p>See also:</p>
						<ul>
							<li><a href="http://j.mp/GL_WPTime" target="_blank">Must Have Awesome Plugins.</a></li>
							<li><a href="http://j.mp/CM_WPTime" target="_blank">Premium WordPress themes on CreativeMarket.</a></li>
							<li><a href="http://j.mp/TF_WPTime" target="_blank">Premium WordPress themes on Themeforest.</a></li>
							<li><a href="http://j.mp/CC_WPTime" target="_blank">Premium WordPress plugins on Codecanyon.</a></li>
							<li><a href="http://j.mp/BH_WPTime" target="_blank">Unlimited web hosting for $3.95 only.</a></li>
						</ul>
					<p><a href="http://j.mp/GL_WPTime" target="_blank"><img src="<?php echo plugins_url( '/banner/global-aff-img.png', __FILE__ ); ?>" width="728" height="90"></a></p>
					<p><a href="http://j.mp/ET_WPTime_ref_pl" target="_blank"><img src="<?php echo plugins_url( '/banner/570x100.jpg', __FILE__ ); ?>"></a></p>
                    <p><a href="http://j.mp/Avada_WP_Theme" target="_blank"><img src="<?php echo plugins_url( '/banner/avada.jpg', __FILE__ ); ?>"></a></p>
				</div>
                
                </div>
			<?php
		}
	}
	add_action( 'admin_menu', 'WP_Time_Ghozylab_Aff' );
}

// Add responsive style to facebook posts
function WPTime_facebook_post_embed_style(){
	?>
    	<style type="text/css">
			div.fb-post{
				width:100% !important;
				max-width:100% !important;
				min-width:100% !important;
				display:block !important;
			}

			div.fb-post *{
				width:100% !important;
				max-width:100% !important;
				min-width:100% !important;
				display:block !important;
			}
		</style>
    <?php
}
add_action('wp_head', 'WPTime_facebook_post_embed_style');


// Add javascript
function WPTime_facebook_post_embed_script(){
	?>
		<div id="fb-root"></div>
		<script type="text/javascript">
			(function(d, s, id) {
  				var js, fjs = d.getElementsByTagName(s)[0];
  				if (d.getElementById(id)) return;
  					js = d.createElement(s); js.id = id;
  					js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.2";
  					fjs.parentNode.insertBefore(js, fjs);
				}
			(document, 'script', 'facebook-jssdk'));
    	</script>
    <?php
}
add_action('wp_footer', 'WPTime_facebook_post_embed_script');


// Add [fb_pe url="" bottom=""] shortcode
function WPTime_facebook_post_embed_shortcode( $atts, $content = null ){

	extract(
		shortcode_atts(
			array(
				"url"		=>	'',
				"bottom" 	=>	'30'
			),$atts
		)
	);

	if( empty($url) ){
		return '<p>Please enter facebook post url.</p>';
		return false;
	}

	if( empty($bottom) or $bottom == '0' ){
		$style = ' style="margin-bottom:0px;"';
	}

	else{
		$style = ' style="margin-bottom:'.$bottom.'px;"';
	}
	
	return '<div class="fb-post wptime-fb-post-embed" data-href="'.$url.'"'.$style.'></div>';
	
}
add_shortcode("fb_pe", "WPTime_facebook_post_embed_shortcode");


// Add facebook button to wp editor
function WPTime_fb_pe_tinymce_button($buttons) {
	array_push($buttons, 'facebook_post_embed');
	return $buttons;
}
add_filter('mce_buttons', 'WPTime_fb_pe_tinymce_button');


// Register js for facebook button
function WPTime_fb_pe_register_tinymce_js($plugin_array) {
	$plugin_array['facebook_post_embed'] = plugins_url( '/js/fb_pe_tinymce_button.js', __FILE__);
	return $plugin_array;
}
add_filter('mce_external_plugins', 'WPTime_fb_pe_register_tinymce_js');


// Add css icon for facebook button
function WPTime_fb_pe_button_icon(){
	?>
		<style type="text/css">
			.mce-i-facebook-post-embed-icon:before{
				font-family: 'dashicons' !important;
				content: '\f304' !important;
				font-size: 24px !important;
			}
		</style>
	<?php
}
add_action('admin_head','WPTime_fb_pe_button_icon');

?>