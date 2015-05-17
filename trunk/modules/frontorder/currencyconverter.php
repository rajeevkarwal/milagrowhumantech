<?php

include_once(dirname(__FILE__) . '/../../config/config.inc.php');
$currencyConvertor = new CurrencyConverter();
$currencyConvertor->refreshCurrency();


Class CurrencyConverter
{
    public function refreshCurrency()
    {
        $baseCurrency = 'INR';
        try {
            $isc_code = array();
            $sql = 'SELECT iso_code ,id_currency,name,conversion_rate from ' . _DB_PREFIX_ . 'currency';
            if ($results = Db::getInstance()->ExecuteS($sql))
                foreach ($results as $key => $row) {
                    $isc_code[$key]['code'] = $row['iso_code'];
                    $isc_code[$key]['id'] = $row['id_currency'];
                    $isc_code[$key]['name'] = $row['name'];
                    $isc_code[$key]['existingConversionRate'] = $row['conversion_rate'];
                }


            $file = 'latest.json';
            $appId = 'c1d7e30516de405c81b31b12e1bf6143';
            $base = 'INR';
// Open CURL session:
            $ch = curl_init("http://openexchangerates.org/api/{$file}?app_id={$appId}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Get the data:
            $json = curl_exec($ch);
            curl_close($ch);
            $errors = array();
// Decode JSON response:
            $exchangeRates = json_decode($json);
            if (isset($exchangeRates->rates->{$baseCurrency})) {
                $exchangeRateDataForEmail = array();
                foreach ($isc_code as $key => $row) {
                    if (!isset($exchangeRates->rates->{$row['code']}))
                        continue;
                    $conversion = $exchangeRates->rates->{$row['code']} / $exchangeRates->rates->{$baseCurrency};
                    if ($row['code'] == $base)
                        continue;
                    $conversion += ($conversion * 2) / 100;

                    try {
                        $sql = 'UPDATE  ' . _DB_PREFIX_ . 'currency  SET  `conversion_rate` =  \'' . $conversion . '\' WHERE  `iso_code`=\'' . $row['code'] . '\'';
                        $currency_shop_sql = 'UPDATE  ' . _DB_PREFIX_ . 'currency_shop  SET  `conversion_rate` =  \'' . $conversion . '\' WHERE  `id_currency`=\'' . $row['id'] . '\'';
                        if (!Db::getInstance()->execute($sql))
                            $errors[] = 'error in updating conversion rate in currency table where iso_code is ' . $row['code'];
                        if (!Db::getInstance()->execute($currency_shop_sql))
                            $errors[] = 'error in updating conversion rate in currency shop table where iso_code is ' . $row['code'];
                        if (empty($errors)) {
                            $exchangeRateDataForEmail[$key]['name'] = $row['name'];
                            $exchangeRateDataForEmail[$key]['code'] = $row['code'];
                            $exchangeRateDataForEmail[$key]['existingRate'] = $row['existingConversionRate'];
                            $exchangeRateDataForEmail[$key]['existingINR'] = round((1 / $row['existingConversionRate']), 2);
                            $exchangeRateDataForEmail[$key]['currentConversionRate'] = round($conversion, 6);
                            $exchangeRateDataForEmail[$key]['currentINR'] = round((1 / round($conversion, 6)), 2);
                        }
                    } catch (Exception $e) {
                        $errors[] = 'exception in updating conversion rate where iso_code is ' . $row['code'] . 'message is ' . $e->getMessage();
                    }

                }
                $this->sendMail($errors, $exchangeRateDataForEmail);
            } else {
                $errors[] = 'error in fetching data from api';

            }


        } catch
        (Exception $e) {
            $errors[] = 'Exception : ' . $e->getMessage();
        }

        if (empty($errors))
            return true;
        else
            return $errors;
    }

    private function sendMail($error = null, $exchangeRateDataForEmail = array())
    {
        $adminEmail = Configuration::get('PS_SHOP_EMAIL');
        if (empty($exchangeRateDataForEmail) && !empty($error)) {
            //error while fetching mail
            $templateName = 'currency_conversion_error';
            $adminVars = array('{currentDate}' => date('d-m-Y H:i:s'), '{error}' => $error[0]);
            $status = Mail::Send(
                (int)1,
                $templateName,
                Mail::l('Currency Conversion Error', (int)1),
                $adminVars,
                $adminEmail,
                'admin',
                null,
                null,
                null,
                null,
                getcwd() . '/',
                false,
                null
            );
        }
        if (!empty($exchangeRateDataForEmail)) {
            $templateName = 'currency_conversion_success';
            $exchangeInfo = '';
            foreach ($exchangeRateDataForEmail as $row) {
                $exchangeInfo .= '<tr><td align="left"> Currency: <strong>' . $row['name'] . '</strong><br/>Existing Currency Rate: <strong>' . $row['existingRate'] . '</strong> <br/>Existing INR Value: <strong>1' . $row['code'] . ' = ' . $row['existingINR'] . 'INR </strong><br/>Updated Currency Rate: <strong>' . $row['currentConversionRate'] . '</strong><br/>Current INR Value: <strong>1' . $row['code'] . ' = ' . $row['currentINR'] . 'INR</strong> <br/></td></tr><br/><br/>';
            }
            $errorInfo = '';
            if (!empty($error)) {
                $errorInfo .= '<tr><td align="left">List of erros occured while conversion are as follows:<br/><ul>';
                foreach ($error as $errorRow) {
                    $errorInfo .= '<li style="list-style: disc">' . $errorRow . '</li>';
                }
                $errorInfo .= '<ul></td></tr><br/><br/>';
            }
            $adminVars = array(
                '{currentDate}' => date('d-m-Y H:i:s'),
                '{exchangeInfo}' => $exchangeInfo,
                '{errorInfo}' => $errorInfo
            );
            //success exchangeRates Changed
            $status = Mail::Send(
                (int)1,
                $templateName,
                Mail::l('Currency Conversion Success', (int)1),
                $adminVars,
                $adminEmail,
                'admin',
                null,
                null,
                null,
                null,
                getcwd() . '/',
                false,
                null
            );
        }

    }
}