<?php
/**
 * Created by PhpStorm.
 * User: hitanshu
 * Date: 22/8/15
 * Time: 9:21 PM
 */
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/damcproducts.php');

$damcOBJ = new DAMCProducts();

$periodId=!empty($_REQUEST['period_id'])?intval($_REQUEST['period_id']):0;
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

if(!empty($periodId) && !empty($action))
{
    if($action=='del')
    {
        if($damcOBJ->deleteDAMCPeriod($periodId))
        {
            die('success');
        }
        else
        {
            die('error');
        }
    }
}

