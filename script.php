<script>

jQuery(document).ready(function ( $ ) {	
    project =  "<?php echo esc_html($slug); ?>";
    last_query = "";
    $(".deepi_data_ajax").click(function(){
        $(this).select2();
    })
    jQuery("#js-data-ajax").select2({
              theme: '<?php echo esc_html($style); ?>',
              //language: 'fa',
              language: '<?php echo substr(get_locale(), 0, 2) ?>',
              dir: 'rtl',
              ajax: {
                url: function (params) {
                  return "https://concept.deepi.ir/concept/api/v1/suggest/" + project + "/";
                },
                dataType: 'json',
                delay: 1000,
                cache: true
              },
              placeholder:
              '<a href="<?php echo (deepi_fetch_key('deepi_link_visibility')=='1')?"https://www.deepi.ir":"#" ?>" target="_blank" style="font-weight:bold; display: inline-block;"><img src="<?php echo deepi__PLUGIN_URL."resources/img/de_logo4.svg";?>" /></a><span><?php echo __('Conceptual search in seventy languages ...', 'deepi') ?></span>',
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

			// Auto focus on jquery 3.6.0
			$(document).on('select2:open', () => {
			   setTimeout(() => document.querySelector('.select2-container--open .select2-search__field').focus(), 200);
               //$('.select2-js-data-ajax-container').attr('title', 'Deepi');
			});

			// Remove placeholder as a title (default title in some cases):
            $('.select2-selection__rendered').hover(function () {
                $(this).removeAttr('title');
            });

            // auto submit on select
            $('#js-data-ajax').change(function(){
                if ($('#js-data-ajax').val() != '' && $('#js-data-ajax').val() != null){
					if($('#js-data-ajax').val().trim != ''){					   
                    	$('#searchform').submit();
					   }
                }
            });
});


</script>
