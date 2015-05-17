<?php

/**
 * @author PresTeamShop.com
 * @copyright PresTeamShop.com - 2013
 */

class ProductExtraTabsCore extends Module {
    public $configVars = array();
    public $prefix_module = ''; 
    
    protected $_configVars = array();    
    public $_errors = array();
    public $_html = '';
    
    protected $_cookie;
    protected $_smarty;

    public function __construct($name = null, $context = null) {
        $this->_errors = array();
        $this->warning = array();
        
        parent::__construct($name, $context);
        
        if (version_compare(_PS_VERSION_, '1.5') >= 0){
            $this->_smarty = $this->context->smarty;
            $this->_cookie = $this->context->cookie;
        }else{
            global $smarty, $cookie;
            
            $this->_smarty = $smarty;
            $this->_cookie = $cookie;
        }   
        
        $this->configVars = $this->getConfigMultiple();            
    }
    
    public function install() {
        foreach ($this->_configVars AS $config)
            if (!Configuration::updateValue($config['name'], $config['default_value']))
                return false;

        if (!parent::install() OR !$this->executeFileSQL('install'))
            return false;
        return true;
    }

    public function uninstall() {
        foreach ($this->_configVars AS $config)
            Configuration::deleteByName($config['name']);
        
        if (!parent::uninstall() OR !$this->executeFileSQL('uninstall'))
            return false;
        return true;
    }
    
    protected function getContent(){
    }
    
    private function executeFileSQL($file_name){        
        if (!file_exists(dirname(__FILE__) . '/../sql/' . $file_name . '.sql'))
            return false;
        else if (!$sql = file_get_contents(dirname(__FILE__) . '/../sql/' . $file_name . '.sql'))
            return false;

        $sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
        $sql = preg_split("/;\s*[\r\n]+/", $sql);

        foreach ($sql as $query)
            if (!Db::getInstance()->Execute(trim($query)))
                return false;
        
        return true;
    }
    
    protected function addFrontOfficeJS($path){     
        if(version_compare(_PS_VERSION_, '1.5') >= 0)
            $this->context->controller->addJS($path);
        else{        
            if (method_exists('Tools', 'addJS'))
                Tools::addJS($path);          
            else{
                global $js_files;
                
                if ( ! is_array($js_files))
                    $js_files = array();
                    
                array_push($js_files, $path);    
            }
        }
    }
    
    protected function addFrontOfficeCSS($path, $media){
        if(version_compare(_PS_VERSION_, '1.5') >= 0)
            $this->context->controller->addCSS($path, $media);
        else{
            if (method_exists('Tools', 'addCSS'))
                Tools::addCSS($path);          
            else{
                global $css_files;
                
                if ( ! is_array($css_files))
                    $css_files = array();
                    
                $css_files[$path] = $media;                
            }
        }
    }
    
    protected function getConfigMultiple(){
        $tmp = array();
        
        foreach ($this->_configVars AS $config)
            $tmp[] = $config['name'];
            
        $tmp[] = $this->prefix_module . '_RM';
            
        return Configuration::getMultiple($tmp);
    }
    
	public function jsonDecode($json, $assoc = false)
	{
		if (function_exists('json_decode'))
			return json_decode($json, $assoc);
		else
		{
			include_once(dirname(__FILE__).'/../lib/JSON.php');
			$pearJson = new Services_JSON(($assoc) ? SERVICES_JSON_LOOSE_TYPE : 0);
			return $pearJson->decode($json);
		}
	}

	public function jsonEncode($data)
	{
		if (function_exists('json_encode'))
			return json_encode($data);
		else
		{
			include_once(dirname(__FILE__).'/../lib/JSON.php');
			$pearJson = new Services_JSON();
			return $pearJson->encode($data);
		}
	}
    
    protected function displayErrors($return = true)
	{
        if (sizeof($this->_errors)){
            $_html = '';
            $nbErrors = sizeof($this->_errors);
            
    		$_html .= '
    		<div class="error">
    			<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
    			<ol>';
    		foreach ($this->_errors AS $error)
    			$_html .= '<li>'.$error.'</li>';
    		$_html .= '
    			</ol>
    		</div>';
            
            if ($return)
                $this->_html = $_html;
            else
                echo $_html;
        }
	}
    
    protected function displayWarnings($return = true)
	{
        if (sizeof($this->warning)){
            $_html = '';
            $nbWarnings = sizeof($this->warning);
            
    		$_html .= '
    		<div class="warn">
    			<h3>'.($nbWarnings > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbWarnings.' '.($nbWarnings > 1 ? $this->l('warnings') : $this->l('warning')).'</h3>
    			<ol>';
    		foreach ($this->warning AS $warning)
    			$_html .= '<li>'.$warning.'</li>';
    		$_html .= '
    			</ol>
    		</div>';
            
            if ($return)
                $this->_html = $_html;
            else
                echo $_html;
        }
	}        

    protected function _sendEmail($email, $subject, $values = array(), $template_name = "default", $email_from = null, $to_name = null, $lang = null, $fileAttachment = null) {
        if ($lang == null) {
            $lang = intval(Configuration::get('PS_LANG_DEFAULT'));
        }
        if ($email_from == null) {
            $email_from = strval(Configuration::get('PS_SHOP_EMAIL'));
        }
        
        return @Mail::Send(
            $lang,                                  //LANG
            $template_name,                         //TEMPLATE
            $subject,                               //SUBJECT
            $values,                                //VALUES
            $email,                                 //TO
            $to_name,                                   //TO NAME
            $email_from,                            //FROM
            NULL,                                   //FROM NAME
            $fileAttachment,                        //FILE ATTACHMENT
            NULL,                                   //MODE SMTP
            _PS_MODULE_DIR_.$this->name.'/mails/'   //DIR TEMPLATE*/
        );
    }    
    
    protected function updateVersion($module)
	{
        $registered_version = Configuration::get($this->prefix_module . '_VERSION');
        
	    if ($registered_version != $this->version)
        {
    		$list = array();
    
    		$upgrade_path = _PS_MODULE_DIR_ . $module->name . '/upgrades/';
    
    		// Check if folder exist and it could be read
    		if (file_exists($upgrade_path) && ($files = scandir($upgrade_path)))
    		{
    			// Read each file name
    			foreach ($files as $file)
    				if (!in_array($file, array('.', '..', '.svn', 'index.php')))
    				{
    					$tab = explode('-', $file);
    					$file_version = basename($tab[1], '.php');
    					// Compare version, if minor than actual, we need to upgrade the module
    					if (count($tab) == 2 && version_compare($registered_version, $file_version) < 0)
    					{
    						$list[] = array(
    							'file' => $upgrade_path.$file,
    							'version' => $file_version,
    							'upgrade_function' => 'upgrade_module_'.str_replace('.', '_', $file_version));
    					}
    				}
    		}
                        
            usort($list,array($this, 'module_version_sort'));
                    
    		foreach ($list as $num => $file_detail)
    		{									
    			include($file_detail['file']);
    
    			// Call the upgrade function if defined
    			if (function_exists($file_detail['upgrade_function']))
    				$upgrade_result = $file_detail['upgrade_function']($module);
    
                unset($list[$num]);
    		}
    
    		Configuration::updateValue($this->prefix_module . '_VERSION', $this->version);
            
            $this->configVars = $this->getConfigMultiple();
        }
	}        
    
    protected function registerModule($email_customer = '', $seller = '', $number_order = '')
	{
            
        return explode('|', $output);            
	}
    
    protected function validateLicenseModule($license_number)
	{
            
        return explode('|', $output);            
	}
    
    private function module_version_sort($a, $b)
    {
        return version_compare($a['version'], $b['version']);
    }
}

?>