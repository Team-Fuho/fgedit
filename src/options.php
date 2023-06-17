<?php
function fuho_register_settings()
{
    register_setting('fuho_options', 'fuho_options');
    add_settings_section('api_settings', 'Database Connection (MongoDB)', 'fuho_gplug_section_text', 'fuho_gplug');

    add_settings_field('fuho_setting_muri', 'Mongo URI', 'fuho_setting_muri', 'fuho_gplug', 'api_settings');
    add_settings_field('fuho_setting_mdbn', 'Mongo Database', 'fuho_setting_mdbn', 'fuho_gplug', 'api_settings');
    add_settings_field('fuho_setting_mcol', 'Mongo Collection', 'fuho_setting_mcol', 'fuho_gplug', 'api_settings');
}
add_action('admin_init', 'fuho_register_settings');

function fuho_settings_renderer()
{
?>
    <h1>Config the gallery</h1>
    <form action="options.php" method="post">
        <?php
        settings_fields('fuho_options');
        do_settings_sections('fuho_gplug'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />
    </form>
<?php
}
function fuho_gplug_section_text()
{
    echo '<p>Set the fucking Mongo API</p>';
}

function fuho_setting_muri()
{
    $options = get_option('fuho_options');
    echo "<input id='fuho_setting_muri' name='fuho_options[muri]' type='text' value='" . esc_attr($options['muri']) . "' />";
}

function fuho_setting_mdbn()
{
    $options = get_option('fuho_options');
    echo "<input id='fuho_setting_mdbn' name='fuho_options[mdbn]' type='text' value='" . esc_attr($options['mdbn']) . "' />";
}

function fuho_setting_mcol()
{
    $options = get_option('fuho_options');
    echo "<input id='fuho_setting_mcol' name='fuho_options[mcol]' type='text' value='" . esc_attr($options['mcol']) . "' />";
}
