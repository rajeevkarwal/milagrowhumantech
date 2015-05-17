















<?php
/*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

// Include Module
include_once(dirname(__FILE__) . '/../../productcomments.php');
// Include Models
include_once(dirname(__FILE__) . '/../../ProductComment.php');
include_once(dirname(__FILE__) . '/../../ProductCommentCriterion.php');

class ProductCommentsDefaultModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->context = Context::getContext();
    }

    public function initContent()
    {
        parent::initContent();

        if (Tools::isSubmit('action')) {
            switch (Tools::getValue('action')) {
                case 'add_comment':
                    $this->ajaxProcessAddComment();
                    break;
                case 'report_abuse':
                    $this->ajaxProcessReportAbuse();
                    break;
                case 'comment_is_usefull':
                    $this->ajaxProcessCommentIsUsefull();
                    break;
            }
        } else {

            $page = Tools::getValue('page');
            $page = !empty($page) ? $page : 1;
            $orderBy = Tools::getValue('sort_order');
            $orderBy = !empty($orderBy) ? $orderBy : 'date';
            $previousPage = 0;
            $nextPage = 0;
            $pageCount = 5;
            $id_guest = (!$id_customer = (int)$this->context->cookie->id_customer) ? (int)$this->context->cookie->id_guest : false;
            $customerComment = ProductComment::getByCustomer((int)(Tools::getValue('id_product')), (int)$this->context->cookie->id_customer, true, (int)$id_guest);

            $averages = ProductComment::getAveragesByProduct((int)Tools::getValue('id_product'), $this->context->language->id);
            $averageTotal = 0;
            foreach ($averages as $average)
                $averageTotal += (float)($average);
            $averageTotal = count($averages) ? ($averageTotal / count($averages)) : 0;

//            $reviewExist = ProductComment::getCommentForProduct((int)(Tools::getValue('id_product')), (int)$this->context->cookie->id_customer);
//            if ($reviewExist) {
//                if (empty($reviewExist['content']) || empty($reviewExist['title'])) {
//                    $title = '';
//                    $content = '';
//                    $grade = $reviewExist['grade'];
//                } else {
//                    $grade = $reviewExist['grade'];
//                    $title = $reviewExist['title'];
//                    $content = $reviewExist['content'];
//                }
//            } else {
//                $title = '';
//                $grade = 0;
//                $content = '';
//            }
//            $image = Product::getCover((int)Tools::getValue('id_product'));
            $product = new Product((int)Tools::getValue('id_product'));
            $countReviews = ProductComment::countReviews((int)Tools::getValue('id_product'));
            $comments = ProductComment::getByProduct((int)Tools::getValue('id_product'), $page, $pageCount, $this->context->cookie->id_customer, $orderBy);
            $resultCount = count($comments);
            $totalReviews = $countReviews['total'];
            if ($page == 1) {
                if ($pageCount > (int)$totalReviews)
                    $showing = 'Showing <b>1-' . $resultCount . '</b> of <b>' . $totalReviews . '</b>';
                else
                    $showing = 'Showing <b>1-' . $pageCount . '</b> of <b>' . $totalReviews . '</b>';
            } else {
                if ($pageCount * ($page - 1) < (int)$totalReviews)
                    $showing = 'Showing <b>' . ((($page - 1) * $pageCount) + 1) . '-' . ($pageCount * $page) . '</b> of <b>' . $totalReviews . '</b>';
                else
                    $showing = 'Showing <b>' . ((($page - 1) * $pageCount) + 1) . '-' . $totalReviews . '</b> of <b>' . $totalReviews . '</b>';
            }

            if (($page * $pageCount) < (int)$totalReviews) {
                $nextPage = $page + 1;
            }
            if ($page > 1)
                $previousPage = $page - 1;

            $this->context->smarty->assign(array(
                'logged' => (int)$this->context->cookie->isLogged(),
                'action_url' => '',
                'comments' => $comments,
//                'criterions' => ProductCommentCriterion::getByProduct((int)Tools::getValue('id_product'), $this->context->language->id),
                'averages' => $averages,
                'product' => $product,
                'product_comment_path' => $this->_path,
                'averageTotal' => $averageTotal,
                'allow_guests' => (int)Configuration::get('PRODUCT_COMMENTS_ALLOW_GUESTS'),
                'too_early' => ($customerComment && (strtotime($customerComment['date_add']) + Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME')) > time()),
                'delay' => Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME'),
                'id_product_comment_form' => (int)Tools::getValue('id_product'),
                'secure_key' => $this->secure_key,
                'page' => $page,
                'previous' => $previousPage,
                'next' => $nextPage,
                'totalReviews' => $totalReviews,
                'showing' => $showing,
                'sortBy' => $orderBy,
                'jsSource1' => $this->module->getPathUri() . 'js/jquery.rating.pack.backup.js',
                'jsSource2' => $this->module->getPathUri() . 'js/jquery.textareaCounter.plugin.js',
                'jsSource3' => $this->module->getPathUri() . 'js/productcomments.js',
//                'productcomment_cover' => (int)Tools::getValue('id_product') . '-' . (int)$image['id_image'],
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
                'nbComments' => (int)ProductComment::getCommentNumber((int)Tools::getValue('id_product')),
//                'existingGrade' => $grade,
//                'existingTitle' => $title,
//                'existingContent' => $content,
                'productcomments_controller_url' => $this->context->link->getModuleLink('productcomments'),
                'productcomments_url_rewriting_activated' => Configuration::get('PS_REWRITING_SETTINGS', 0)
            ));

//            $this->context->controller->pagination((int)ProductComment::getCommentNumber((int)Tools::getValue('id_product')));
            $this->setTemplate('productReviews.tpl');

        }
    }


    protected function ajaxProcessAddComment()
    {
        $module_instance = new ProductComments();
        $result = true;
        $id_guest = 0;
        $id_customer = $this->context->customer->id;
        if (!$id_customer) {
            $errors[] = $module_instance->l('You must be login to give review');
        }

        $id_guest = $this->context->cookie->id_guest;


        $errors = array();
        // Validation
        if (!Validate::isInt(Tools::getValue('id_product')))
            $errors[] = $module_instance->l('ID product is incorrect');
        if (!Tools::getValue('title') || !Validate::isGenericName(Tools::getValue('title')))
            $errors[] = $module_instance->l('Title is incorrect');
        if (!Tools::getValue('content') || !Validate::isMessage(Tools::getValue('content')))
            $errors[] = $module_instance->l('Comment is incorrect');
        if (!$id_customer && (!Tools::isSubmit('customer_name') || !Tools::getValue('customer_name') || !Validate::isGenericName(Tools::getValue('customer_name'))))
            $errors[] = $module_instance->l('Customer name is incorrect');
        if (!$this->context->customer->id && !Configuration::get('PRODUCT_COMMENTS_ALLOW_GUESTS'))
            $errors[] = $module_instance->l('You must be logged in order to send a comment');
        if (!count(Tools::getValue('criterion')))
            $errors[] = $module_instance->l('You must give a rating');

        $product = new Product(Tools::getValue('id_product'));
        if (!$product->id)
            $errors[] = $module_instance->l('Product not found');


        if (!count($errors)) {

            $customer_comment = ProductComment::getCommentForProduct(Tools::getValue('id_product'), $id_customer);
            if ($customer_comment) {
                //update comment
                $id_product_comment = $customer_comment['id_product_comment'];
                $existing_id_customer = $customer_comment['id_customer'];
                $title = $customer_comment['title'];
                $content = $customer_comment['content'];
                $grade_sum = 0;
                foreach (Tools::getValue('criterion') as $id_product_comment_criterion => $grade) {
                    $grade_sum += $grade;
                    $product_comment_criterion = new ProductCommentCriterion($id_product_comment_criterion);
                    if ($product_comment_criterion->id) {
                        if (empty($title) && empty($content))
                            $product_comment_criterion->addGrade($id_product_comment, $grade);
                        else
                            $product_comment_criterion->updateGrade($id_product_comment, $id_product_comment_criterion, $grade);
                    }
                }

                Db::getInstance()->update('product_comment', array('grade' => $grade_sum, 'validate' => 0, 'date_add' => date('Y-m-d H:i:s'), 'title' => Tools::getValue('title'), 'content' => Tools::getValue('content')), "id_product_comment=$id_product_comment");
                $affectedRows = Db::getInstance()->Affected_Rows();
                if ($affectedRows) {
                    $result = true;
                    //deleting comment useful entry
                    Db::getInstance()->delete('product_comment_usefulness', "id_product_comment=$id_product_comment");
                    //deleting report abuse entries also
                    Db::getInstance()->delete('product_comment_report', "id_product_comment=$id_product_comment");
                } else {
                    $error[] = 'Sorry an error occured while updating review';
                    if (empty($title) && empty($content))
                        $error[] = 'Sorry an error occured while inserting review';
                    $result = false;
                }

            } else {
                //insert comment
                $comment = new ProductComment();
                $comment->content = strip_tags(Tools::getValue('content'));
                $comment->id_product = (int)Tools::getValue('id_product');
                $comment->id_customer = (int)$id_customer;
                $comment->id_guest = $id_guest;
                $comment->customer_name = Tools::getValue('customer_name');
                if (!$comment->customer_name)
                    $comment->customer_name = pSQL($this->context->customer->firstname . ' ' . $this->context->customer->lastname);
                $comment->title = Tools::getValue('title');
                $comment->grade = 0;
                $comment->validate = 0;
                $comment->save();

                $grade_sum = 0;
                foreach (Tools::getValue('criterion') as $id_product_comment_criterion => $grade) {
                    $grade_sum += $grade;
                    $product_comment_criterion = new ProductCommentCriterion($id_product_comment_criterion);
                    if ($product_comment_criterion->id)
                        $product_comment_criterion->addGrade($comment->id, $grade);
                }

                if (count(Tools::getValue('criterion')) >= 1) {
                    $comment->grade = $grade_sum / count(Tools::getValue('criterion'));
                    // Update Grade average of comment
                    $comment->save();
                }
                $result = true;
            }

        } else
            $result = false;

        die(Tools::jsonEncode(array(
            'result' => $result,
            'errors' => $errors
        )));
    }

//	protected function ajaxProcessAddComment()
//	{
//		$module_instance = new ProductComments();
//
//		$result = true;
//		$id_guest = 0;
//		$id_customer = $this->context->customer->id;
//		if (!$id_customer)
//			$id_guest = $this->context->cookie->id_guest;
//
//		$errors = array();
//		// Validation
//		if (!Validate::isInt(Tools::getValue('id_product')))
//			$errors[] = $module_instance->l('ID product is incorrect');
//		if (!Tools::getValue('title') || !Validate::isGenericName(Tools::getValue('title')))
//			$errors[] = $module_instance->l('Title is incorrect');
//		if (!Tools::getValue('content') || !Validate::isMessage(Tools::getValue('content')))
//			$errors[] = $module_instance->l('Comment is incorrect');
//		if (!$id_customer && (!Tools::isSubmit('customer_name') || !Tools::getValue('customer_name') || !Validate::isGenericName(Tools::getValue('customer_name'))))
//			$errors[] = $module_instance->l('Customer name is incorrect');
//		if (!$this->context->customer->id && !Configuration::get('PRODUCT_COMMENTS_ALLOW_GUESTS'))
//			$errors[] = $module_instance->l('You must be logged in order to send a comment');
//		if (!count(Tools::getValue('criterion')))
//			$errors[] = $module_instance->l('You must give a rating');
//
//		$product = new Product(Tools::getValue('id_product'));
//		if (!$product->id)
//			$errors[] = $module_instance->l('Product not found');
//
//		if (!count($errors))
//		{
//			$customer_comment = ProductComment::getByCustomer(Tools::getValue('id_product'), $id_customer, true, $id_guest);
//			if (!$customer_comment || ($customer_comment && (strtotime($customer_comment['date_add']) + Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME')) < time()))
//			{
//
//				$comment = new ProductComment();
//				$comment->content = strip_tags(Tools::getValue('content'));
//				$comment->id_product = (int)Tools::getValue('id_product');
//				$comment->id_customer = (int)$id_customer;
//				$comment->id_guest = $id_guest;
//				$comment->customer_name = Tools::getValue('customer_name');
//				if (!$comment->customer_name)
//					$comment->customer_name = pSQL($this->context->customer->firstname.' '.$this->context->customer->lastname);
//				$comment->title = Tools::getValue('title');
//				$comment->grade = 0;
//				$comment->validate = 0;
//				$comment->save();
//
//				$grade_sum = 0;
//				foreach(Tools::getValue('criterion') as $id_product_comment_criterion => $grade)
//				{
//					$grade_sum += $grade;
//					$product_comment_criterion = new ProductCommentCriterion($id_product_comment_criterion);
//					if ($product_comment_criterion->id)
//						$product_comment_criterion->addGrade($comment->id, $grade);
//				}
//
//				if (count(Tools::getValue('criterion')) >= 1)
//				{
//					$comment->grade = $grade_sum / count(Tools::getValue('criterion'));
//					// Update Grade average of comment
//					$comment->save();
//				}
//				$result = true;
//			}
//			else
//			{
//				$result = false;
//				$errors[] = $module_instance->l('You should wait').' '.Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME').' '.$module_instance->l('seconds before posting a new comment');
//			}
//		}
//		else
//			$result = false;
//
//		die(Tools::jsonEncode(array(
//			'result' => $result,
//			'errors' => $errors
//		)));
//	}

    protected function ajaxProcessReportAbuse()
    {
        if (!Tools::isSubmit('id_product_comment'))
            die('0');

        if (ProductComment::isAlreadyReport(Tools::getValue('id_product_comment'), $this->context->cookie->id_customer))
            die('0');

        if (ProductComment::reportComment((int)Tools::getValue('id_product_comment'), $this->context->cookie->id_customer))
            die('1');

        die('0');
    }

    protected function ajaxProcessCommentIsUsefull()
    {
        if (!Tools::isSubmit('id_product_comment') || !Tools::isSubmit('value'))
            die('0');

        if (ProductComment::isAlreadyUsefulness(Tools::getValue('id_product_comment'), $this->context->cookie->id_customer))
            die('0');

        if (ProductComment::setCommentUsefulness((int)Tools::getValue('id_product_comment'), (bool)Tools::getValue('value'), $this->context->cookie->id_customer))
            die('1');

        die('0');
    }
}
