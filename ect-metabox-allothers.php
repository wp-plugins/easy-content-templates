<?php
$templates_own = get_posts(array('author' => get_current_user_id(), 'numberposts' => -1, 'post_type' => 'ec-template', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC',));
$exclusions = array();
foreach($templates_own as $template_own) $exclusions[] = $template_own->ID;
$templates_public = get_posts(array('exclude' => $exclusions, 'meta_key' => ec_templates::post_meta_key_public, 'meta_value' => 1, 'numberposts' => -1, 'post_type' => 'ec-template', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC',));
if(empty($templates_own) && empty($templates_public)):
?>
    You haven't defined any templates yet.
<?php
else:
?>
<div style="margin-bottom: 4px;">
    <select id="ddl_ect_mtb_template_id" name="ect_mtb_template_id" style="width: 100%;">
        <option value="0">-- select template --</option>
<?php
    if(!empty($templates_own)):
?>
        <optgroup label="Your templates">
<?php
        foreach($templates_own as $template):
?>
            <option value="<?php echo $template->ID; ?>"><?php echo $template->post_title; ?></option>
<?php
        endforeach;
?>
        </optgroup>
<?php
    endif;
    if(!empty($templates_public)):
?>
        <optgroup label="Templates shared with">
<?php
        foreach($templates_public as $template):
?>
            <option value="<?php echo $template->ID; ?>"><?php echo $template->post_title; ?></option>
<?php
        endforeach;
?>
        </optgroup>
<?php
    endif;
?>
    </select>
</div>
<div style="margin-bottom: 10px;">
    <input type="checkbox" id="chk_ect_load_title" name="ect_load_title" value="1" checked="checked" />
    <label for="chk_ect_load_title">Title</label>
    <input type="checkbox" id="chk_ect_load_content" name="ect_load_content" value="1" checked="checked" />
    <label for="chk_ect_load_content">Content</label>
    <input type="checkbox" id="chk_ect_load_excerpt" name="ect_load_excerpt" value="1" checked="checked" />
    <label for="chk_ect_load_excerpt">Excerpt</label>
</div>
<div style="text-align: center;">
    <button id="btn_ect_mtb_load" class="button">Load Template</button>
</div>
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('#btn_ect_mtb_load').click(function(event){
                event.preventDefault();
                var template_id = $('#ddl_ect_mtb_template_id').val();
                if(template_id == 0){
                    alert('Please select the template you want to load!');
                }else{
                    $.ajax({
                        'data': {
                            'action': 'ect_get_template',
                            'template_id': template_id
                        },
                        'dataType': 'json',
                        'error': function(){alert('Something went wrong! Please contact the plugin author.\nBTW is your WordPress address "<?php bloginfo('url'); ?>"?');},
                        'global': false,
                        'success': function(data){
                            if(data.success == 1){
                                // load title
                                if($('#chk_ect_load_title:checked').length > 0) $('#title').val(unescape(data.title)).focus().blur();

                                // load content
                                var visual_mode = !(typeof(tinyMCE) != 'undefined' && (tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() != false));
                                switchEditors.go('content', 'html');
                                if($('#chk_ect_load_content:checked').length > 0) $('#content').val(unescape(data.content));
                                if(visual_mode) switchEditors.go('content', 'tinymce');

                                // load excerpt
                                if($('#chk_ect_load_excerpt:checked').length > 0) $('#excerpt').val(unescape(data.excerpt));
                            }else{
                                alert(data.message);
                            }
                        },
                        'timeout': 3000,
                        'type': 'POST',
                        'url': '<?php echo admin_url('admin-ajax.php'); ?>'
                    });
                }
            });
        });
    })(jQuery);
</script>
<?php
endif;
?>
