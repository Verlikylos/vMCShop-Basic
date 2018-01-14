<?php

 /**
 * Created with ♥ by Verlikylos on 05.04.2017 16:30.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop 2017
 */

function check($userid, $serviceid, $service_number, $code) {
    if (preg_match("/^[A-Za-z0-9]{8}$/", $code)) {
        $url = 'https://microsms.pl/api/v2/multi.php?userid=' . $userid . '&code=' . $code . '&serviceid=' . $serviceid;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $api = json_decode($res, true);
        
        if ((isset($api['data']['errorCode']))) {
            if ($api['data']['errorCode'] == 1) {
                return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
            } else {
                return array('value' => false, 'message' => 'Wystapił błąd podczas pobierania informacji z serwera płatności! Spróbuj ponownie później!3');
            }
        }
        if ($api['data']['used'] == 1) {
            return array('value' => false, 'message' => 'Ten kod został już użyty!');
        }
        if (($api['data']['service'] != $serviceid) || ($api['data']['number'] != $service_number)) {
            return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
        }

        if ((isset($api['connect'])) && ($api['connect'] == true)) {
            if ($api['data']['status'] == 1) {
                return array('value' => true, 'message' => 'Usługa została pomyślnie zrealizowana!');
            } else {
                return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
            }
        }
    } else {
        return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
    }
}