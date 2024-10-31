<?php 
    $is_enabled = get_option('ns-enable-ab', false);
    if($is_enabled == 'on')
        $is_enabled = true;
    if($is_enabled){
        $ns_ab_font_awesome = get_option('ns-ab-font-awesome', 'far fa-frown');
        $ns_ab_font_awesome_size = get_option('ns-ab-font-awesome-size', 'md');
        $ns_ab_page_text = get_option('ns-ab-page-text', "Please, turn off your Ad Blocker.");
        $ns_ab_font_awesome_color = get_option('ns-ab-font-awesome-color', '#ff3a3a');

    switch($ns_ab_font_awesome_size){
        case 'sm': 
            $ns_ab_font_awesome_size = 'fa-4x';
            break;
        case 'md': 
            $ns_ab_font_awesome_size = 'fa-7x';
            break;
        case 'lg': 
            $ns_ab_font_awesome_size = 'fa-10x';
            break;
    }
        
?>
        <div class="ns-text-align">
            <div class="ns-mb-5 ns-mt-5">
                <div class="ns-row">
                    <i class="<?php echo $ns_ab_font_awesome.' '; echo $ns_ab_font_awesome_size.' ';?>" <?php echo "style=\"color:$ns_ab_font_awesome_color;\"";?>></i>
                </div>
                <div class="ns-row ns-mt-3">
                    <?php _e($ns_ab_page_text , 'ns-detect-spy'); ?>
                </div>
            </div>
        </div>
<?php
    }
?>