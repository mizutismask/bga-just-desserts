<?php

/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 * 
 * states.inc.php
 *
 * JustDesserts game states description
 *
 */

/*
   Game state machine is a tool used to facilitate game developpement by doing common stuff that can be set up
   in a very easy way from this configuration file.

   Please check the BGA Studio presentation about game state to understand this, and associated documentation.

   Summary:

   States types:
   _ activeplayer: in this type of state, we expect some action from the active player.
   _ multipleactiveplayer: in this type of state, we expect some action from multiple players (the active players)
   _ game: this is an intermediary state where we don't expect any actions from players. Your game logic must decide what is the next game state.
   _ manager: special type for initial and final state

   Arguments of game states:
   _ name: the name of the GameState, in order you can recognize it on your own code.
   _ description: the description of the current game state is always displayed in the action status bar on
                  the top of the game. Most of the time this is useless for game state with "game" type.
   _ descriptionmyturn: the description of the current game state when it's your turn.
   _ type: defines the type of game states (activeplayer / multipleactiveplayer / game / manager)
   _ action: name of the method to call when this game state become the current game state. Usually, the
             action method is prefixed by "st" (ex: "stMyGameStateName").
   _ possibleactions: array that specify possible player actions on this step. It allows you to use "checkAction"
                      method on both client side (Javacript: this.checkAction) and server side (PHP: self::checkAction).
   _ transitions: the transitions are the possible paths to go from a game state to another. You must name
                  transitions in order to use transition names in "nextState" PHP method, and use IDs to
                  specify the next game state for each transition.
   _ args: name of the method to call to retrieve arguments for this gamestate. Arguments are sent to the
           client side to be used on "onEnteringState" or to set arguments in the gamestate description.
   _ updateGameProgression: when specified, the game progression is updated (=> call to your getGameProgression
                            method).
*/

//    !! It is not a good idea to modify this file when a game is running !!

// define contants for state ids
if (!defined('STATE_END_GAME')) { // ensure this block is only invoked once, since it is included multiple times
    define("STATE_PLAYER_TURN", 2);
    define("STATE_NEXT_PLAYER", 23);
    define("STATE_DISCARD", 24);
    define("STATE_SERVE_SECOND_GUEST", 25);
    define("STATE_END_GAME", 99);
}

$machinestates = array(

    // The initial state. Please do not modify.
    1 => array(
        "name" => "gameSetup",
        "description" => "",
        "type" => "manager",
        "action" => "stGameSetup",
        "transitions" => array("" => STATE_NEXT_PLAYER)
    ),

    // Note: ID=2 => your first state

    STATE_PLAYER_TURN => array(
        "name" => "playerTurn",
        "description" => clienttranslate('${actplayer} must draw a dessert, serve guests or swap desserts'),
        "descriptionmyturn" => clienttranslate('${you} must choose 1 action'),
        "type" => "activeplayer",
        "possibleactions" => array("draw", "serve", "swap"),
        "transitions" => array("draw" => STATE_NEXT_PLAYER, "serve" => STATE_NEXT_PLAYER, "serveSecondGuest" => STATE_SERVE_SECOND_GUEST, "swap" => STATE_NEXT_PLAYER, "discardGuest" => STATE_DISCARD, "endGame" => STATE_END_GAME)
    ),


    STATE_NEXT_PLAYER => array(
        "name" => "nextPlayer",
        "description" => '',
        "type" => "game",
        "action" => "stNextPlayer",
        "updateGameProgression" => true,
        "transitions" => array("playerTurn" => STATE_PLAYER_TURN)
    ),

    STATE_DISCARD => array(
        "name" => "playerDiscardGuest",
        "description" => clienttranslate('${actplayer} must discard guests to keep only one of each suit'),
        "descriptionmyturn" => clienttranslate('${you} must discard guests to keep only one of each suit'),
        "type" => "activeplayer",
        "possibleactions" => array("discardGuests"),
        "transitions" => array("discardGuests" => STATE_NEXT_PLAYER)
    ),

    STATE_SERVE_SECOND_GUEST => array(
        "name" => "serveSecondGuest",
        "description" => clienttranslate('${actplayer} can serve another guest'),
        "descriptionmyturn" => clienttranslate('${you} must serve another guest or pass'),
        "type" => "activeplayer",
        "possibleactions" => array("pass", "serveSecondGuest"),
        "transitions" => array("pass" => STATE_NEXT_PLAYER, "serveSecondGuest" => STATE_NEXT_PLAYER, "discardGuest" => STATE_DISCARD, "endGame" => 99)
    ),


    /*
    Examples:
    
    2 => array(
        "name" => "nextPlayer",
        "description" => '',
        "type" => "game",
        "action" => "stNextPlayer",
        "updateGameProgression" => true,   
        "transitions" => array( "endGame" => 99, "nextPlayer" => 10 )
    ),
    
    10 => array(
        "name" => "playerTurn",
        "description" => clienttranslate('${actplayer} must play a card or pass'),
        "descriptionmyturn" => clienttranslate('${you} must play a card or pass'),
        "type" => "activeplayer",
        "possibleactions" => array( "playCard", "pass" ),
        "transitions" => array( "playCard" => 2, "pass" => 2 )
    ), 

*/

    // Final state.
    // Please do not modify (and do not overload action/args methods).
    99 => array(
        "name" => "gameEnd",
        "description" => clienttranslate("End of game"),
        "type" => "manager",
        "action" => "stGameEnd",
        "args" => "argGameEnd"
    )

);
