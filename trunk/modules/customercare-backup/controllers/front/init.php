<?php
define('_PS_HELP_DESK_ACTION', 'http://milagrow.letshelp.io');
class CustomerCareInitModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {

        parent::initContent();
        if (!$this->context->customer->isLogged()) {
            $back = Tools::getShopDomainSsl(true, true);
            $back .= '/module/customercare/init';
            Tools::redirect('index.php?controller=authentication&back=' . $back);
        }

        $token = $this->context->customer->secure_key;
        $email = $this->context->customer->email;

       $action = _PS_HELP_DESK_ACTION . '/?email=' . $email . '&auth_token=' . $token;
//        $action = _PS_HELP_DESK_ACTION;
       Tools::redirectLink($action);
        $this->context->smarty->assign(array(
            'action' => $action,
            'email' => $email,
            'token' => $token
        ));

        $this->setTemplate('default.tpl');
    }


}
