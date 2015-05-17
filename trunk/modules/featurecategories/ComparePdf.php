<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 31/8/13
 * Time: 2:11 PM
 * To change this template use File | Settings | File Templates.
 */

include_once(dirname(__FILE__) . '/../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../init.php');
include_once(_PS_MODULE_DIR_ . 'featurecategories/HTMLTemplateComparePdf.php');
include_once(_PS_MODULE_DIR_ . 'featurecategories/GeneratorPDF.php');

class ComparePdf
{
    public function __construct($smarty)
    {
        $this->pdf_renderer = new GeneratorPDF((bool)Configuration::get('PS_PDF_USE_CACHE'));
        $this->smarty = $smarty;
    }

    public function render($display = true)
    {
        $this->pdf_renderer->setFontForLang(Context::getContext()->language->iso_code);
        $template = new HTMLTemplateComparePdf($this->smarty);
        $this->filename = $template->getFilename();
        $this->pdf_renderer->createHeader($template->getHeader());
        $this->pdf_renderer->createFooter($template->getFooter());
        $this->pdf_renderer->createContent($template->getContent());
        $this->pdf_renderer->writePage();
        $render = true;

        unset($template);


        if ($render) {
            // clean the output buffer
            if (ob_get_level() && ob_get_length() > 0)
                ob_clean();
            return $this->pdf_renderer->render($this->filename, $display);
        }
    }
}