<?php
/**
 * Created with ♥ by Verlikylos on 10.09.2017 15:37.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop 2017
 */

function check($userid, $apikey, $serviceid, $code) {
    if (preg_match("/^[A-Za-z0-9]{8}$/", $code)) {

        $config = array(
            'id' => $userid,
            'key' => $apikey,
            'command' => 'CheckSms',
            'account' => $serviceid,
            'code' => $code
        );

        $json = json_encode($config);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://homepay.pl/api');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept:application/json, text/javascript, */*; q=0.01', 'Content-Length: ' . strlen($json)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        var_dump($result);
        exit();
        $json = json_decode($result, true);
        if($json['code'] == "1")
            return array('value' => true, 'message' => 'Usługa została pomyślnie zrealizowana!');
        else if($json['code'] == "0")
            return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
        else
            return array('value' => false, 'message' => 'Wystąpił błąd podczas łączenia się z operatorem płatności!');
    } else {
        return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
    }
}