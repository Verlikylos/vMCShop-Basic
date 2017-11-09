<?php
/**
 * Created with ♥ by Verlikylos on 08.11.2017 00:22.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
 */

require APPPATH.'libraries/SourceQuery/bootstrap.php';

function rconCommand($ip, $rconPort, $rconPass, $commands, $player = null) {
    $Query = new \xPaw\SourceQuery\SourceQuery();

    try {
        $Query->Connect($ip, $rconPort, 1, \xPaw\SourceQuery\SourceQuery::SOURCE);

        $Query->SetRconPassword($rconPass);

        $output = array();

        foreach ($commands as $command) {
            if ($player == null) {
                array_push($output, $Query->Rcon($command));
            } else {
                array_push($output, $Query->Rcon(str_replace(array('{player}', '{PLAYER}'), $player, $command)));
            }
        }

        return array('value' => true, 'message' => 'Polecenia zostały pomyślnie wysłane na serwer', 'output' => $output);
    } catch (Exception $e) {
        return array('value' => false, 'message' => 'Wystąpił błąd podczas komunikacji z serwerem!');
    } finally {
        $Query->Disconnect();
    }
}