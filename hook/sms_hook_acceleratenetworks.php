<?php

//set the include path
$conf = glob("{/usr/local/etc,/etc}/fusionpbx/config.conf", GLOB_BRACE);
set_include_path(parse_ini_file($conf[0])['document.root']);

//includes files
require_once "resources/require.php";
require_once "../sms_hook_common.php";

// if ($debug) {
// 	error_log('[SMS] REQUEST: ' .  print_r($_SERVER, true));
// }

$data = json_decode(file_get_contents("php://input"));
if ($debug) {
	error_log('[SMS] REQUEST: ' .  print_r($data, true));
}

route_and_send_sms($data->{'From'}, $data->{'To'}, $data->{'Content'});
