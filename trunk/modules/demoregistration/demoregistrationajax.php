<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 29/11/15
 * Time: 9:21 PM
 */
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');


include(dirname(__FILE__).'/demoregistration.php');
$damcOBJ = new DemoRegistration();

$actionType=!empty($_REQUEST['action_type'])?intval($_REQUEST['action_type']):0;
$demoId=!empty($_REQUEST['demo_id'])?intval($_REQUEST['demo_id']):0;
$demoCityId=!empty($_REQUEST['demo_city_id'])?intval($_REQUEST['demo_city_id']):0;
$secureKey=!empty($_REQUEST['secureKey'])?intval($_REQUEST['secureKey']):0;
$action=!empty($_REQUEST['action'])?$_REQUEST['action']:'';

if(empty($secureKey))
{
    die('error secure key required');
}

if($secureKey!=345768)
{
    die('error secure key entered is wrong');
}

if($actionType==1)
{

    if(!empty($demoId) && !empty($action))
    {
        if($action==1)
        {
            if($damcOBJ->changeStatusOfDemoProducts($demoId,$action))
            {
                die('success');
            }
            else
            {
                die('error');
            }
        }
        elseif($action==2)
        {
            if($damcOBJ->changeStatusOfDemoProducts($demoId,$action))
            {
                die('success');
            }
            else
            {
                die('error');
            }
        }
    }
    else
    {
        die('error');
    }
}
elseif($actionType==2)
{
       if(!empty($demoCityId))
       {
           if($damcOBJ->deleteDemoProductCities($demoCityId))
           {
               die('success');
           }
           else
           {
               die('error');
           }
       }
}
else
{
    die('action type is wrong');
}