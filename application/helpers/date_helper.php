<?php
/**
 * Created with ♥ by Verlikylos on 01.11.2017 15:24.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
 */

ini_set('date.timezone', 'Europe/Warsaw');

function getOnlyDate($timestamp) {
    return date("d-m-Y", $timestamp);
}

function getDayNumber($timestamp) {
    return date("N", $timestamp);
}

function getDateTime($timestamp) {
    return date("H:i:s, d-m-Y", $timestamp);
}

function formatDate($timestamp) {
    ini_set('date.timezone', 'Europe/Warsaw');
    $now = time();

    if ($timestamp > $now) {
        return "Error!";
    }

    $seconds = $now - $timestamp;
    $minutes = round($seconds / 60, 0);
    $hours = round($minutes / 60, 0);
    $days = round($hours / 24, 0);

    switch ($seconds) {
        case ($seconds <= 10):
            return "Przed chwilą";
        case ($seconds <= 59):
            return $seconds . " sekund temu";
    }

    switch ($minutes) {
        case (1):
            return "Minutę temu";
        case ($minutes <= 4):
            return $minutes . " minuty temu";
        case ($minutes <= 59):
            return $minutes . " minut temu";
    }

    switch ($hours) {
        case (1):
            return "Godzinę temu";
        case ($hours <= 4):
            return $hours . " godziny temu";
        case ($hours <= 23):
            return $hours . " godzin temu";
    }

    switch ($days) {
        case (1):
            return "Wczoraj";
        case (2):
            return "Przedwczoraj";
        case ($days <= 6):
            return $days . " dni temu";
        case ($days == 7):
            return "Tydzień temu";
    }

    switch (date('n', $timestamp)) {
        case (1):
            return date('j', $timestamp) . " stycznia" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (2):
            return date('j', $timestamp) . " lutego" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (3):
            return date('j', $timestamp) . " marca" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (4):
            return date('j', $timestamp) . " kwietnia" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (5):
            return date('j', $timestamp) . " maja" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (6):
            return date('j', $timestamp) . " czerwca" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (7):
            return date('j', $timestamp) . " lipca" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (8):
            return date('j', $timestamp) . " sierpnia" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (9):
            return date('j', $timestamp) . " września" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (10):
            return date('j', $timestamp) . " października" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (11):
            return date('j', $timestamp) . " listopada" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
        case (12):
            return date('j', $timestamp) . " grudnia" . (date('Y', $timestamp) == date('Y', $now) ? '' : " " . date('Y', $timestamp)) . " o " . date('H:i', $timestamp);
    }
}