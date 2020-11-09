<?php

/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © Séverine Kamycki severinek@gmail.com
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * gameoptions.inc.php
 *
 * JustDesserts game options description
 * 
 * In this file, you can define your game options (= game variants).
 *   
 * Note: If your game has no variant, you don't have to modify this file.
 *
 * Note²: All options defined in this file should have a corresponding "game state labels"
 *        with the same ID (see "initGameStateLabels" in justdesserts.game.php)
 *
 * !! It is not a good idea to modify this file when a game is running !!
 *
 */
require_once("modules/php/constants.inc.php");

$game_options = array(

    // note: game variant ID should start at 100 (ie: 100, 101, 102, ...). The maximum is 199.
    TYPE_OF_RULES => array(
        'name' => totranslate('Rules'),
        'values' => array(
            BASIC_RULES => array('name' => totranslate('Basic rules')),
            ADVANCED_RULES => array('name' => totranslate('Advanced rules')),
        ),
        'default' => BASIC_RULES
    ),
    OPENING_BUFFET => array(
        'name' => totranslate('Opening a buffet'),
        'values' => array(
            ACTIVATED => array('name' => totranslate('Yes')),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'displaycondition' => [
            [
                'type' => 'otheroption',
                'id' => TYPE_OF_RULES,
                'value' => ADVANCED_RULES,
            ],
        ],
    ),
    POACHING => array(
        'name' => totranslate('Poaching and blocking'),
        'values' => array(
            ACTIVATED => array('name' => totranslate('Yes')),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'displaycondition' => [
            [
                'type' => 'otheroption',
                'id' => TYPE_OF_RULES,
                'value' => ADVANCED_RULES,
            ],
        ],
    ),


);
