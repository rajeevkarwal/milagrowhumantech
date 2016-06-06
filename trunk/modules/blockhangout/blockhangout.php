<?php
if (!defined('_CAN_LOAD_FILES_'))
        exit;
class BlockHangout extends Module
{
	function __construct()
	{
		$this->name = 'blockhangout';
		$this->tab = 'front_office_features';
		$this->author = 'Hitanshu Malhotra';
                $this->need_instance = 0;
                $this->version = '1.0';

                parent::__construct();

		$this->displayName = $this->l('Hangout Call Button');
		$this->description = $this->l('Display Hangout Button');
		
		if (!Configuration::get('BLOCK_HANGOUT_ID'))
			$this->warning = $this->l('You have not yet set your Hangout App Id');
	}

	function install()
	{
		if (!parent::install()
		    OR !$this->registerHook('displayFooter'))
			return false;
		return true;
	}

    public function hookdisplayFooter($params)
    {

        global $smarty;

        $hangout_id = Configuration::get('BLOCK_HANGOUT_ID');
        $hangout_app_type = Configuration::get('BLOCK_HANGOUT_APP_TYPE');
        if(empty($hangout_app_type))
            $hangout_app_type='LOCAL_APP';
        $hangout_emails = Configuration::get('BLOCK_HANGOUT_EMAIL');

        $hangoutEmailBlock="[
                  { id : 'kishor.pant@milagrow.in', invite_type : 'EMAIL' }]";
        if(!empty($hangout_emails))
        {
            $hangoutEmailBlock="[";
            $selectedEmails=explode(',',$hangout_emails);

            foreach($selectedEmails as $key=>$emailItem)
            {

                if(count($selectedEmails)==1 || $key==count($selectedEmails)-1)
                $hangoutEmailBlock.="{ id : '$emailItem', invite_type : 'EMAIL' }";
                else
                    $hangoutEmailBlock.="{ id : '$emailItem', invite_type : 'EMAIL' },";
            }

            $hangoutEmailBlock.="]";
        }

        $smarty->assign('hangout_app_id', $hangout_id);
        $smarty->assign('hangout_invite_block', $hangoutEmailBlock);
        $smarty->assign('hangout_app_type', $hangout_app_type);

        return $this->display(__FILE__, 'blockhangout.tpl');
    }

	public function getContent()
        {
                $output = '<h2>'.$this->displayName.'</h2>';
                if (Tools::isSubmit('submitBlockHangout'))
                {
                        $hangout_id = (string)(Tools::getValue('hangout_id'));
                        if (empty($hangout_id) OR strlen($hangout_id) < 1)
                                $errors[] = $this->l('Your Hangout Project id is Invalid.');
                        else    
                                Configuration::updateValue('BLOCK_HANGOUT_ID', (string)($hangout_id));

                        $app_type = (string)(Tools::getValue('app_type'));
                         Configuration::updateValue('BLOCK_HANGOUT_APP_TYPE', (string)($app_type));

                        $app_email = (string)(Tools::getValue('hangout_email'));
                        if (empty($app_email))
                        $errors[] = $this->l('Your hangout invite email is empty');
                        else
                        Configuration::updateValue('BLOCK_HANGOUT_EMAIL', (string)($app_email));

                        if (isset($errors) AND sizeof($errors))
                                $output .= $this->displayError(implode('<br />', $errors));
                        else
                                $output .= $this->displayConfirmation($this->l('Your settings have been updated.'));
                }
                return $output.$this->displayForm();
        }
	public function displayForm()
        {
                $output = '
                <form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
                        <fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
                                <p>'.$this->l('Add a Hangout button to your websites and let people get in touch with just the click of a button.').'</p><br />
                                <label>'.$this->l('Your Hangout App Id*').'</label>
                                <div class="margin-form">
                                        <input type="text" size="15" name="hangout_id" value="'.Tools::safeOutput(Tools::getValue('hangout_id', (string)(Configuration::get('BLOCK_HANGOUT_ID')))).'" />
                                        <p class="clear">'.$this->l('Hangout App Id here.').'</p>

                                </div>
                                <label>'.$this->l('Your APP Type').'</label>
                                <div class="margin-form">
                                        <input type="text" size="15" name="app_type" value="'.Tools::safeOutput(Tools::getValue('app_type', (string)(Configuration::get('BLOCK_HANGOUT_APP_TYPE')))).'" />
                                        <p class="clear">'.$this->l('Your APP Type Here').'</p>

                                </div>
                                <label>'.$this->l('Email Invites comma seprated').'</label>
                                <div class="margin-form">
                                        <input type="text" size="15" name="hangout_email" value="'.Tools::safeOutput(Tools::getValue('hangout_email', (string)(Configuration::get('BLOCK_HANGOUT_EMAIL')))).'" />
                                        <p class="clear">'.$this->l('Your email invites (comma seprated)').'</p>

                                </div>
                                <center><input type="submit" name="submitBlockHangout" value="'.$this->l('Save').'" class="button" /></center>
                        </fieldset>
                </form>';
                return $output;
        }

}
?>
