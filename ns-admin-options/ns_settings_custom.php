<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$checked = '';
$is_enabled = get_option('ns-enable-ab', '');
if($is_enabled == 'on')
	$checked = 'checked';
$redirect_type = get_option('ns-redirect-ab', '');
$default_page_id = get_option('ns_ab_page');
$redirect_link = ns_ab_get_redirect_url();

$ns_ab_font_awesome = get_option('ns-ab-font-awesome', 'far fa-frown');
$ns_ab_font_awesome_size = get_option('ns-ab-font-awesome-size', 'md');
$ns_ab_font_awesome_color = get_option('ns-ab-font-awesome-color', '#ff3a3a');
$ns_ab_page_text = get_option('ns-ab-page-text', "Please, turn off your Ad Blocker.");
?>
<?php // PUT YOUR settings_fields name and your input // ?>
<div class="genRowNssdc">
<div class="ns-ctbc-section-container">
	
			
		<script>
		jQuery(document).ready(function($) {
			$('#ns-redirect-ab').change(function(){
				var val = $('#ns-redirect-ab').val();
				if(val == 'default'){
					$('#ns-redirect-ab-link').val('<?php echo get_permalink($default_page_id) ?>');
					$('#ns-redirect-ab-link').attr('readonly', true);
				}else{
					$('#ns-redirect-ab-link').val('<?php echo get_option('ns-redirect-ab-link', get_permalink($default_page_id)) ?>');
					$('#ns-redirect-ab-link').attr('readonly', false);
				}
				var val_preview = $('#ns-redirect-ab-link').val();
				$('#ns-preview-link').attr('href', val_preview);
				$('#ns-edit-ab-page').toggle('slow');
			});

			$('#ns-redirect-ab-link').focusout(function(){
				var val = $('#ns-redirect-ab-link').val();
				$('#ns-preview-link').attr('href', val);
			});
			$('#ns-ab-font-awesome-color').wpColorPicker();
			
		});

		</script>
	

		<div class="ns-enable-ab">
			<label class="ns-ctbc-container"><input class="ns-ctbc-checkbox" type="checkbox" name="ns-enable-ab" id="ns-ctbc-checkbox" <?php echo $checked; ?>><span class="ns-ctbc-checkmark"></span></label>
			<label><?php _e('Enable AdBlock Blocker', $ns_text_domain) ?></label>
		</div>
		<br><br>
		<div class="ns-redirect-ab">
			<label><?php _e('Redirect on ad blocker active on:', $ns_text_domain) ?></label><br>
			<select name="ns-redirect-ab" id="ns-redirect-ab">
				<option value="default"><?php _e('Default AdBlock Blocker Page', $ns_text_domain) ?></option>
				<option value="custom" <?php if($redirect_type == 'custom') echo 'selected'; ?> ><?php _e('Custom Page', $ns_text_domain) ?></option>
			</select>
			<br><br>
			<label><?php _e('Locked page link: ', $ns_text_domain)?><a href="<?php echo $redirect_link?>" target="_blank" id="ns-preview-link"><?php _e('Preview', $ns_text_domain) ?></a></label><br>
			<input type="text" name="ns-redirect-ab-link" id="ns-redirect-ab-link" class="ns-ctbc-input ns-input-text-ab" <?php if($redirect_type != 'custom') echo 'readonly '; echo "value=\"$redirect_link\""; ?>>
		</div>
		<br>
		<div id="ns-edit-ab-page" <?php if($redirect_type == 'custom') echo 'style="display:none"'; ?>>
			<label><?php _e('Font-Awesome image (left blank for null): ', $ns_text_domain)?></label><br>
			<input type="text" name="ns-ab-font-awesome" id="ns-ab-font-awesome" placeholder="far fa-frown" <?php echo "value=\"$ns_ab_font_awesome\""; ?> class="ns-ctbc-input ns-input-text-ab">
			<br>
			<label><?php _e('Font-Awesome size: ', $ns_text_domain)?></label><br>
			<select name="ns-ab-font-awesome-size" id="ns-ab-font-awesome-size">
				<option value="sm" <?php if($ns_ab_font_awesome_size == 'sm') echo 'selected'; ?>><?php _e('Small', $ns_text_domain) ?></option>
				<option value="md" <?php if($ns_ab_font_awesome_size == 'md') echo 'selected'; ?>><?php _e('Medium', $ns_text_domain) ?></option>
				<option value="lg" <?php if($ns_ab_font_awesome_size == 'lg') echo 'selected'; ?>><?php _e('Large', $ns_text_domain) ?></option>
			</select>
			<br><br>
			<label><?php _e('Color: ', $ns_text_domain)?></label><br>
			<input type="text" name="ns-ab-font-awesome-color" id="ns-ab-font-awesome-color"<?php echo "value=\"$ns_ab_font_awesome_color\"";; ?> >
			<br>
			<label><?php _e('Page content text: ', $ns_text_domain)?></label><br>
			<input type="text" name="ns-ab-page-text" id="ns-ab-page-text" placeholder="Please, turn off your Ad Blocker." <?php echo "value=\"$ns_ab_page_text\""; ?> class="ns-ctbc-input ns-input-text-ab">		
			<!--  -->
		</div>
</div>
<?php 
submit_button();
settings_fields('ns_ab_options_group'); 
?>