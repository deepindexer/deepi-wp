# Tips
## compile .po
* install gettext and use `msgfmt` command: `msgfmt deepi-fa_IR.po -o deepi-fa_IR.mo`

# Notes
* if your theme supports shortcode use `[deepi_form]` to display the searchbar, or use this php script:
```php
<?php 
if(function_exists('deepi_selectbox')){
    deepi_selectbox();
}
?>
```