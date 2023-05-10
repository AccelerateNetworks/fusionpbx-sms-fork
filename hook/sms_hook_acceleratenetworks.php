<?php

//set the include path
$conf = glob("{/usr/local/etc,/etc}/fusionpbx/config.conf", GLOB_BRACE);
set_include_path(parse_ini_file($conf[0])['document.root']);

//includes files
require_once "resources/require.php";
require_once "../sms_hook_common.php";

$data = json_decode(file_get_contents("php://input"));
if ($debug) {
	error_log('[SMS] REQUEST: ' .  print_r($data, true));
}

$sql = "SELECT default_setting_value FROM v_default_settings WHERE default_setting_category = 'sms' AND default_setting_subcategory = 'acceleratenetworks_inbound_token'";
$database = new database;
$token = $database->select($sql, null, 'column');
unset($parameters);

if($data->ClientSecret != $token) {
	error_log('ACCESS DENIED [SMS] invalid or missing ClientSecret token');
	die("access denied");
}

$to = $data->To;
if(is_array($to)) {
	$to = $to[0];
}

route_and_send_sms($data->{'From'}, $to, $data->{'Content'});
