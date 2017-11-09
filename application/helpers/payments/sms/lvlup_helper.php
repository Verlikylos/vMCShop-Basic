<?php
/**
 * Created with ♥ by Verlikylos on 14.08.2017 23:54.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop 2017
 */

function check($userid, $servicenumber, $code) {
    $desc = "[vMCShop] Przychod z ItemShopu.";
    $site = file_get_contents("https://lvlup.pro/api/checksms?id=".$userid."&code=".$code."&number=".$servicenumber."&desc=".urlencode($desc));
    $json = json_decode($site);

    if ($json->valid) {
        return array('value' => true, 'message' => 'Usługa została pomyślnie zrealizowana!');
    } else {
        return array('value' => false, 'message' => 'Podany kod jest nieprawidłowy!');
    }
}