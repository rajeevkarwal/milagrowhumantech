<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 5/9/13
 * Time: 5:02 PM
 * To change this template use File | Settings | File Templates.
 */


include_once(dirname(__FILE__) . '/../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../init.php');
$email = Tools::getValue('email');
$category = Tools::getValue('category');
$mobile = Tools::getValue('mobile');
$message = Tools::getValue('message');
$experience = Tools::getValue('experience');
$currentUrl = Tools::getValue('currentUrl');
$currentUrl = !empty($currentUrl) ? Tools::getShopDomainSsl(true, true) . $currentUrl : '-';
$categoriesNameMapping = array(1 => 'Improve this page', 2 => 'Suggest new features/ideas', 3 => 'Suggest new products/categories', 4 => 'Shopping experience', 5 => 'Feedback on prices/offers', 6 => 'Others -General Feedback');

$adminVars = array(
    '{email}' => !empty($email) ? $email : '-',
    '{mobile}' => !empty($mobile) ? $mobile : '-',
    '{message}' => !empty($message) ? $message : '-',
    '{currentUrl}' => $currentUrl,
    '{category}' => !empty($category) ? $categoriesNameMapping[$category] : '',
    '{experience}' => !empty($experience) ? $experience : '-'
);

//if (_PS_ENVIRONMENTS) {
    $customerCareEmailId = Configuration::get('MILAGROW_CUSTOMER_CARE_EMAIL');
//} else {
//    $customerCareEmailId = Configuration::get('PS_SHOP_EMAIL');
//}

$templateName = 'feedback_admin_mail_without_experience';
if (!empty($category) && $category == 4 && !empty($experience)) {
    $templateName = 'feedback_admin_mail_with_experience';
}

$currentDate = new DateTime('now', new DateTimeZone('UTC'));
$currentTime = $currentDate->format("Y-m-d H:i:s");
$insertData = array('email' => $email, 'mobile' => $mobile, 'message' => $message, 'currentUrl' => $currentUrl,
    'category' => $category, 'experience' => $experience, 'created_at' => $currentTime, 'updated_at' => $currentTime);

if (Db::getInstance()->insert('feedbacks', $insertData)) {
//sending mail to milagrow related to form details
    Mail::Send(
        (int)1,
        $templateName,
        Mail::l('FeedBack Entry', (int)1),
        $adminVars,
        $customerCareEmailId,
        'admin',
        null,
        null,
        null,
        null,
        getcwd() . '/',
        false,
        null
    );
    echo true;
} else {
    echo false;
}

exit;