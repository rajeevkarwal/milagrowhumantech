<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/WishList.php');
require_once(dirname(__FILE__).'/blockwishlist.php');

$errors = array();

$action = Tools::getValue('action');
$add = (!strcmp($action, 'add') ? 1 : 0);
$delete = (!strcmp($action, 'delete') ? 1 : 0);
$id_wishlist = (int)(Tools::getValue('id_wishlist'));
$id_product = (int)(Tools::getValue('id_product'));
$quantity = (int)(Tools::getValue('quantity'));
$id_product_attribute = (int)(Tools::getValue('id_product_attribute'));
if (Configuration::get('PS_TOKEN_ENABLE') == 1 AND
strcmp(Tools::getToken(false), Tools::getValue('token')) AND
$cookie->isLogged() === true)
echo $module->l('Invalid token', 'cart');
if ($cookie->isLogged())
{
if ($id_wishlist AND WishList::exists($id_wishlist, $cookie->id_customer) === true)
$cookie->id_wishlist = (int)($id_wishlist);
if (empty($cookie->id_wishlist) === true OR $cookie->id_wishlist == false)
$smarty->assign('error', true);
if (($add OR $delete) AND empty($id_product) === false)
{

$wishlists = Wishlist::getByIdCustomer($cookie->id_customer);
if (!empty($wishlists))
{
$id_wishlist = (int)$wishlists[0]['id_wishlist'];
$cookie->id_wishlist = (int)$id_wishlist;
}
else

{
$wishlist = new WishList();
$modWishlist = new BlockWishList();
$wishlist->name = $modWishlist->default_wishlist_name;
$wishlist->id_customer = (int)($cookie->id_customer);
    $wishlist->id_shop = $context->shop->id;
    $wishlist->id_shop_group = $context->shop->id_shop_group;
list($us, $s) = explode(' ', microtime());
srand($s * $us);
$wishlist->token = strtoupper(substr(sha1(uniqid(rand(), true)._COOKIE_KEY_.$cookie->id_customer), 0, 16));
$wishlist->add();
$cookie->id_wishlist = (int)($wishlist->id);
}
if ($add AND $quantity)
WishList::addProduct($cookie->id_wishlist, $cookie->id_customer, $id_product, $id_product_attribute, $quantity);
else if ($delete)
WishList::removeProduct($cookie->id_wishlist, $cookie->id_customer, $id_product, $id_product_attribute);
}
$smarty->assign('products', WishList::getProductByIdCustomer($cookie->id_wishlist, $cookie->id_customer, $cookie->id_lang, null, true));

if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/blockwishlist/blockwishlist-ajax.tpl'))
$smarty->display(_PS_THEME_DIR_.'modules/blockwishlist/blockwishlist-ajax.tpl');
elseif (Tools::file_exists_cache(dirname(__FILE__).'/blockwishlist-ajax.tpl'))
$smarty->display(dirname(__FILE__).'/blockwishlist-ajax.tpl');
else
echo Tools::displayError('No template found');
}
else
echo Tools::displayError('You must be logged in to manage your wishlist.');
