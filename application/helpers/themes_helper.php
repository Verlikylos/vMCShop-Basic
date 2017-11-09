<?php
/**
 * Created with ♥ by Verlikylos on 14.10.2017 19:58.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
 */

function getTheme($theme = 'custom') {
    $theme = strtolower($theme);
    return base_url('assets/css/bootstrap/' . $theme . '.css');
}

function getLogBadge($section) {
    switch ($section) {
        case "Logowanie":
            return '<span class="badge badge-info">' . $section . '</span>';
        default:
            return '<span class="badge badge-info">' . $section . '</span>';
    }
}