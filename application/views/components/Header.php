<!--
 * Created with ♥ by Verlikylos on 11.09.2017 21:00.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="<?php echo $settings['pageDesc']; ?>" />
        <meta name="keywords" content="<?php echo $settings['pageTags']; ?>" />
        <link rel="icon" type="image/png" href="<?php echo $settings['favicon']; ?>"/>
        <meta name="author" content="Verlikylos" />
        <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if ($this->uri->rsegment('1') == "checkout" && $this->uri->rsegment('2') == "paypal"): ?>
            <meta http-equiv="Pragma" content="no-cache" />
            <meta http-equiv="Expires" content="-1" />
            <meta http-equiv="Cache-Control" content="no-cache" />
        <?php endif; ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo getTheme($settings['pageTheme']); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
        <title><?php echo $page_title; ?></title>
        <?php if (substr($settings['pageBackground'], 0, 1) == "#"): ?>
            <style>
                body {
                    background: <?php echo $settings['pageBackground']; ?>;
                }
            </style>
        <?php else: ?>
            <style>
                body {
                    background: url('<?php echo $settings['pageBackground']; ?>') fixed;
                }
            </style>
        <?php endif; ?>
    </head>