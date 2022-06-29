<?php
function deepi_selectbox(){
    if(deepi_is_active()!=true or deepi_fetch_key('form_visibility')=='0'){
        return;
    }
    
    $slug = deepi_fetch_key('slug');
    $style = deepi_fetch_key('style');
    deepi_loadJS();
    ?>
    <div id='deepi_container_style_<?php echo esc_html($style); ?>' class='deepi_search_form_container'>        
        <form id="searchform" class="form needs-validation" 
            novalidate
            action="https://www.deepi.ir/fa/dashboard/search/"
            method="get">
                <input type="hidden" id="project" name="project" value="<?php echo $slug; ?>">

                <select style="width:20%;" id="js-data-ajax" class="left" name="query" required></select> 
        </form>
    </div>
    <?php
}
?>

<?php
function deepi_loadJS(){
    $slug = deepi_fetch_key('slug');
    $style = deepi_fetch_key('style');
    ?>



<script>
    jQuery(document).ready(function ( $ ) {	
            last_query = "";
            $("#js-data-ajax").select2({
              theme: '<?php echo esc_html($style); ?>',
              language: 'fa',
              dir: 'rtl',
              ajax: {
                url: function (params) {
                  return "https://concept.deepi.ir/concept/api/v1/suggest/<?php echo esc_html($slug); ?>/";
                },
                dataType: 'json',
                delay: 1000,
                cache: true
              },
              placeholder:
              '<a href="<?php echo (deepi_fetch_key('deepi_link_visibility')=='1')?"https://www.deepi.ir":"#" ?>" target="_blank" style="font-weight:bold;"><img src="<?php echo deepi__PLUGIN_URL."resources/img/de_logo4.svg";?>" style="height:20px; opacity:50%; padding-left: 5px; margin-bottom:-5px;"/></a><?php _e('Search in 70 languages...','deepi'); ?>',
              escapeMarkup: function(markup){ return markup; },
              minimumInputLength: 2,
              tags: true,
            }).on('select2:closing', function (e) {
                currentQuery = $('.select2-search input').prop('value').trim();
                selectedValue = $('#js-data-ajax').find(':selected').text();
            }).on('select2:close', function (e) {
                if (last_query == ""){
                    $('#js-data-ajax').val(currentQuery).trigger('change');
                    last_query = currentQuery;
                } else if (selectedValue == null){
                    $('#js-data-ajax').val(currentQuery).trigger('change');
                    last_query = currentQuery;
                }
            }).on('select2:open', function (e) {
                if (typeof currentQuery !== 'undefined'){
                    $('.select2-search input').val(currentQuery).trigger('change').trigger("input");
                }else if(`` !== ""){
                    $('.select2-search input').val(``).trigger('change').trigger("input");
                }
            }).on('select2:select', function (e) {
                $('#js-data-ajax').val(selectedValue).trigger('change');
            });

            // auto submit on select
            $('#js-data-ajax').change(function(){
                if ($('#js-data-ajax').val().trim() != ''){
                    $('#searchform').submit();
                }
            });
        });
</script>

<?php 
}

add_shortcode('deepi_form', 'deepi_selectbox');