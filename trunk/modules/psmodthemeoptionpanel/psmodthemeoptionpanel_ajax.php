<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once(dirname(__FILE__) . '/psmodthemeoptionpanel.php');
$sccoptionpanel = new PsModThemeOptionPanel();
$click_button = $_POST['type'];


if ($click_button == 'sccoptiondata') {
    $possccata = $_POST['data'];

    parse_str($possccata, $data);
    foreach ($data as $id => $output) {
      if($id=="perfec_bgimages")
        print_r($id.$output) ;
        if (is_array($output)) {
            foreach ($output as $key => $output_value) {
                Configuration::updateValue($id . "_" . $key, $output_value, true, 0, 0);
            }
        } else {
            Configuration::updateValue($id, htmlspecialchars($output), true, 0, 0);
        }
    }
}
elseif ($click_button == 'image_upload') {
    $post_id = $_POST['data']; 
    $file_name = $_FILES[$post_id];
    $file_name['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $file_name['name']);

    move_uploaded_file($file_name['tmp_name'], 'upload/' . $file_name['name']);

    echo  __PS_BASE_URI__ . 'modules/psmodthemeoptionpanel/upload/' . $file_name['name'];
}elseif ($click_button == 'image_reset') {
    Configuration::deleteByName($_POST['data']);
}
die();    