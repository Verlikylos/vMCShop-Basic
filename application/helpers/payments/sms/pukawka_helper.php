<?php
/**
 * Created with ♥ by Verlikylos on 10.09.2017 17:53.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop 2017
 */

function check($apikey, $pricebrutto, $code) {

    $desc = "[vMCShop] Przychod z ItemShopu.";
    $result = file_get_contents("https://admin.pukawka.pl/api/?keyapi=$apikey&type=sms&code=$code&desc=$desc");

    if ($result) {
        $result = json_decode($result);

        if (is_object($result)) {
            if($result->error) {
                return array('value' => false, 'message' => 'Wystąpił błąd podczas łączenia się z operatorem płatności!');
            } else {
                $status = $result->status;

                if ($status=="ok") {
                    if ($pricebrutto != $result->kwota) {
                        return array('value' => false, 'message' => 'Niestety ten kod nie działa z tą usługą!');
                    }
                    return array('value' => true, 'message' => 'Usługa została pomyślnie zrealizowana!');
                } else {
                    return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
                }
            }
        } else {
            return array('value' => false, 'message' => 'Wystąpił błąd podczas łączenia się z operatorem płatności!');
        }
    } else {
        return array('value' => false, 'message' => 'Wystąpił błąd podczas łączenia się z operatorem płatności!');
    }
}