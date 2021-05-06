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
            BASIC_RULES => array('name' => totranslate('Basic rules'), 'tmdisplay' => totranslate('Basic rules'), 'description' => totranslate('A simple version to learn the game')),
            ADVANCED_RULES => array('name' => totranslate('Advanced rules'), 'tmdisplay' => totranslate('Advanced rules'), 'description' => totranslate('More strategic rules')),
        ),
        'default' => ADVANCED_RULES
    ),
    OPENING_BUFFET => array(
        'name' => totranslate('Opening a buffet'),
        'values' => array(
            ACTIVATED => array('name' => totranslate('Yes'), 'tmdisplay' => totranslate('Opening a buffet'), 'description' => totranslate('Make opponents give back their guests')),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'default' => ACTIVATED,
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
            ACTIVATED => array('name' => totranslate('Yes'), 'tmdisplay' => totranslate('Poaching and blocking'), 'description' => totranslate('Steal your opponents guests')),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'default' => ACTIVATED,
        'displaycondition' => [
            [
                'type' => 'otheroption',
                'id' => TYPE_OF_RULES,
                'value' => ADVANCED_RULES,
            ],
        ],
    ),
    EXPANSION_BACON => array(
        'name' => totranslate('Better with bacon expansion'),
        'values' => array(
            ACTIVATED => array(
                'name' => totranslate('Yes'), 'tmdisplay' => totranslate('Better with bacon'),
                'description' => totranslate('New cards and a new flavor : bacon'), 'premium' => true
            ),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'default' => DEACTIVATED,
    ),
    EXPANSION_COFFEE => array(
        'name' => totranslate('Just coffee expansion'),
        'values' => array(
            ACTIVATED => array(
                'name' => totranslate('Yes'), 'tmdisplay' => totranslate('Just coffee'),
                'description' => totranslate('New cards and a new flavor : coffee'), 'premium' => true
            ),
            DEACTIVATED => array('name' => totranslate('No')),
        ),
        'default' => DEACTIVATED,
    ),
);
