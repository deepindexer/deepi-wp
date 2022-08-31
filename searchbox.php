<?php
function deepi_selectbox(){
    if(deepi_is_active()!=true or deepi_fetch_key('form_visibility')=='0'){
        return;
    }

    if(is_user_logged_in()){
        ?>
        <script>
            jQuery(document).ready(function ( $ ) {	
                $("html").attr('style','margin-top:0 !important;');
            });       
        </script>
        <style>
            .select2-selection__placeholder{
                position:relative; 
                top:-4px;
            }
        </style>
        <?php
    }
    else{
        ?>
        <style>
            .select2-selection__placeholder{
                position:relative;
                top:-7px;
            }
        </style>
        <?php
    }
    
    $slug = deepi_fetch_key('slug');
    $style = deepi_fetch_key('style');
    deepi_loadJS();
    ?>
    <div class='container' style="width:100%;">
        <form id="searchform" class="deepi_search_forms form needs-validation"  
            novalidate 
            action="https://www.deepi.ir/en/dashboard/search/"
            method="get" target="_blank">
                <input type="hidden" id="project" name="project" value="<?php echo esc_html($slug); ?>">

                <select style="width:100%;" id="js-data-ajax" class="left deepi_data_ajax" name="query" required></select> 
        </form>
    </div>
    <?php
}

function deepi_loadJS(){
    $slug = deepi_fetch_key('slug');
    $style = deepi_fetch_key('style');
    include_once(deepi__PLUGIN_DIR . "script.php");
    ?>



<?php 
}

add_shortcode('deepi_form', 'deepi_selectbox');