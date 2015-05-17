{*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="add-to-box-link">
    <ul class="add-to-links">
        <li><a rel="tooltip"  title="{l s='Add to Wishlist' mod='blockwishlist'}" class="link-wishlist" onclick="WishlistCart('wishlist_block_list', 'add', '{$id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"><span></span>{l s='Add to Wishlist' mod='blockwishlist'}</a></li>
        <li><span class="separator">|</span> <a rel="tooltip" title="{l s='Add to Compare' mod='blockwishlist'}" class="link-compare link-compare"  id="comparator_item_{$id_product|intval}"><span></span>{l s='Add to Compare' mod='blockwishlist'}</a></li>
    </ul>
   
</div>    
