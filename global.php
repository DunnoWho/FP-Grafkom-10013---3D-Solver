<?php
function loadView($url, $data)
{
    ob_start();
    include($url);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}