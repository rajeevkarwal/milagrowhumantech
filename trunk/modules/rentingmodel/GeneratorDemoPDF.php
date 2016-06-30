<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hitanshu
 * Date: 2/9/13
 * Time: 11:16 AM
 * To change this template use File | Settings | File Templates.
 */
require_once(_PS_TOOL_DIR_ . 'tcpdf/config/lang/eng.php');
require_once(_PS_TOOL_DIR_ . 'tcpdf/tcpdf.php');

class GeneratorDemoPDF extends TCPDF
{
    const DEFAULT_FONT = 'arial';
    public $header;
    public $footer;
    public $content;
    public $font;

    public $font_by_lang = array(
        'ja' => 'cid0jp',
        'bg' => 'freeserif',
        'ru' => 'freeserif',
        'uk' => 'freeserif',
        'mk' => 'freeserif',
        'el' => 'freeserif',
        'vn' => 'dejavusans',
        'pl' => 'dejavusans',
        'ar' => 'dejavusans',
        'fa' => 'dejavusans',
        'ur' => 'dejavusans',
        'az' => 'dejavusans',
        'ca' => 'dejavusans',
        'gl' => 'dejavusans',
        'hr' => 'dejavusans',
        'sr' => 'dejavusans',
        'si' => 'dejavusans',
        'cs' => 'dejavusans',
        'sk' => 'dejavusans',
        'ka' => 'dejavusans',
        'he' => 'dejavusans',
        'lo' => 'dejavusans',
        'lv' => 'dejavusans',
        'tr' => 'dejavusans',
        'ko' => 'cid0kr',
        'zh' => 'cid0cs',
        'tw' => 'cid0cs',
        'th' => 'freeserif'
    );


    public function __construct($use_cache = false)
    {
        parent::__construct('P', 'mm', 'A4', true, 'UTF-8', $use_cache, false);
    }

    /**
     * set the PDF encoding
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     *
     * set the PDF header
     * @param string $header HTML
     */
    public function createHeader($header)
    {
        $this->header = $header;
    }

    /**
     *
     * set the PDF footer
     * @param string $footer HTML
     */
    public function createFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     *
     * create the PDF content
     * @param string $content HTML
     */
    public function createContent($content)
    {
        $this->content = $content;
    }

    /**
     * Change the font
     * @param string $iso_lang
     */
    public function setFontForLang($iso_lang)
    {
        $this->font = PDFGenerator::DEFAULT_FONT;
        if (array_key_exists($iso_lang, $this->font_by_lang))
            $this->font = $this->font_by_lang[$iso_lang];

        $this->setHeaderFont(array($this->font, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(array($this->font, '', PDF_FONT_SIZE_MAIN));

        $this->setFont($this->font);
    }

    /**
     * @see TCPDF::Header()
     */
    public function Header()
    {
        $this->writeHTML($this->header);
    }

    /**
     * @see TCPDF::Footer()
     */
    public function Footer()
    {
//        $this->writeHTML($this->footer);
        $this->writeHTML('<table style="width: 100%"><tr><td style="text-align:left; width:30%">Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages() . '</td><td style="width:70%;text-align:left">This is a computer generated invoice does not requires signatures</td></tr></table>');
    }

    /**
     * Render the pdf file
     *
     * @param string $filename
     * @param  $display :  true:display to user, false:save, 'I','D','S' as fpdf display
     * @throws PrestaShopException
     */
    public function render($filename, $display = true)
    {
        if (empty($filename))
            throw new PrestaShopException('Missing filename.');

        $this->lastPage();

        if ($display === true)
            $output = 'D';
        elseif ($display === false)
            $output = 'S'; elseif ($display == 'D')
            $output = 'D'; elseif ($display == 'S')
            $output = 'S'; else
            $output = 'I';

        return $this->output($filename, $output);
    }

    /**
     * Write a PDF page
     */
    public function writePage()
    {
        $this->SetHeaderMargin(5);
        $this->SetFooterMargin(10);
        $this->setMargins(10, 30, 10, false);
        $this->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        $this->AddPage();

        $this->writeHTML($this->content, true, false, true, true, '');
    }

    /**
     * Override of TCPDF::getRandomSeed() - getmypid() is blocked on several hosting
     */
    protected function getRandomSeed($seed = '')
    {
        $seed .= microtime();
        if (function_exists('openssl_random_pseudo_bytes') AND (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) {
            // this is not used on windows systems because it is very slow for a know bug
            $seed .= openssl_random_pseudo_bytes(512);
        } else {
            for ($i = 0; $i < 23; ++$i) {
                $seed .= uniqid('', true);
            }
        }
        $seed .= uniqid('', true);
        $seed .= rand();
        $seed .= __FILE__;
        $seed .= $this->bufferlen;
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $seed .= $_SERVER['REMOTE_ADDR'];
        }
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $seed .= $_SERVER['HTTP_USER_AGENT'];
        }
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            $seed .= $_SERVER['HTTP_ACCEPT'];
        }
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $seed .= $_SERVER['HTTP_ACCEPT_ENCODING'];
        }
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $seed .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }
        if (isset($_SERVER['HTTP_ACCEPT_CHARSET'])) {
            $seed .= $_SERVER['HTTP_ACCEPT_CHARSET'];
        }
        $seed .= rand();
        $seed .= uniqid('', true);
        $seed .= microtime();
        return $seed;
    }
}
