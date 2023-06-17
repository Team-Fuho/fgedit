<?php
$pluginpath = dirname(__FILE__);
require_once($pluginpath. "/../../../../wp-config.php");
function fuho_conn()
{
    $options = get_option('fuho_options');
    $client = new MongoDB\Client(
        // using fuho_setting_muri
        $options['muri']
    );
    $dbName = get_option('fuho_options')['mdbn'];
    $db = $client->$dbName;
    $collection = $db->{get_option('fuho_options')['mcol']};

    return $collection;
}