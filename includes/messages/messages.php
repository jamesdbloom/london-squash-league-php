<?php

function get_message($key, $dir)
{
    $resource_bundle = ROOT_PATH . $dir . '/messages/errors.php';
    $message_array = include $resource_bundle;
    return '<p>' . $message_array[$key] . '</p>';
}

?>