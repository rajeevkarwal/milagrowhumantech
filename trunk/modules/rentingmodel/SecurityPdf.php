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
$path = _PS_MODULE_DIR_ . 'rentingmodel/HTMLTemplateDemoPdf.php';
include_once(_PS_MODULE_DIR_ . 'rentingmodel/HTMLTemplateDemoPdf.php');
include_once(_PS_MODULE_DIR_ . 'rentingmodel/GeneratorDemoPDF1.php');

class SecurityPdf
{
    public function __construct($smarty)
    {
        $this->pdf_renderer = new GeneratorDemoPDF1((bool)Configuration::get('PS_PDF_USE_CACHE'));
        $this->smarty = $smarty;
    }

    public function render($display = true, $content)
    {
        $this->pdf_renderer->setFontForLang(Context::getContext()->language->iso_code);
        $template = new HTMLTemplateDemoPdf($this->smarty);
        $this->filename = $template->getFilename($content['receiptNo']);
        $template->content = $content;
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

    public function renderBulkDemoReceipt($display = true, $contents)
    {
        foreach ($contents as $row) {
            $this->pdf_renderer->setFontForLang(Context::getContext()->language->iso_code);
            $template = new HTMLTemplateDemoPdf($this->smarty);
            if (empty($this->filename)) {
                $this->filename = $template->getFilename();
                if (count($contents) > 1)
                    $this->filename = $template->getBulkFilename();
            }
            $template->content = $row;
            $this->pdf_renderer->createHeader($template->getHeader());
            $this->pdf_renderer->createFooter($template->getFooter());
            $this->pdf_renderer->createContent($template->getContent());
            $this->pdf_renderer->writePage();
            $render = true;

            unset($template);

        }

        if ($render) {
            // clean the output buffer
            if (ob_get_level() && ob_get_length() > 0)
                ob_clean();
            return $this->pdf_renderer->render($this->filename, $display);
        }
    }

}