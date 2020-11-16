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
    define("STATE_BUFFET_DISCARD", 26);
    define("STATE_POACHING_REACTION", 27);
    define("STATE_POACHING_RESOLVED", 28);

    define("STATE_END_GAME", 99);

    define("TRANSITION_DRAWN", "drawn");
    define("TRANSITION_SERVED", "served");
    define("TRANSITION_SWAPPED", "swapped");
    define("TRANSITION_DISCARD_GUEST_NEEDED", "discardGuestNeeded");
    define("TRANSITION_SECOND_GUEST_SERVED", "secondGuestServed");
    define("TRANSITION_PLAYER_TURN", "playerTurn");
    define("TRANSITION_GUESTS_DISCARDED", "guestsDiscarded");
    define("TRANSITION_PASSED", "passed");
    define("TRANSITION_END_GAME", "endGame");
    define("TRANSITION_BUFFET_OPENED", "buffetOpened");
    define("TRANSITION_BUFFET_GUEST_DISCARDED", "buffetGuestDiscarded");
    define("TRANSITION_BUFFET_SERVE", "buffetServe");
    define("TRANSITION_POACHING_ATTEMPT", "poachingAttempt");
    define("TRANSITION_POACHING_BLOCKED", "poachingBlocked");
    define("TRANSITION_POACHING_RESOLVED", "poachingUnblockable");
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
        "description" => clienttranslate('${actplayer} must serve guests, draw a dessert or dump desserts'),
        "descriptionmyturn" => clienttranslate('${you} must choose 1 action'),
        "type" => "activeplayer",
        "possibleactions" => array("draw", "serve", "swap", "openBuffet", "poach"), //swap is the same as dump
        "args" => "argGetPossibleMoves",
        "transitions" => array(
            TRANSITION_DRAWN => STATE_NEXT_PLAYER,
            TRANSITION_SERVED => STATE_SERVE_SECOND_GUEST,
            TRANSITION_SECOND_GUEST_SERVED => STATE_NEXT_PLAYER,
            TRANSITION_SWAPPED => STATE_NEXT_PLAYER,
            TRANSITION_DISCARD_GUEST_NEEDED => STATE_DISCARD,
            TRANSITION_END_GAME => STATE_END_GAME,
            TRANSITION_BUFFET_OPENED => STATE_BUFFET_DISCARD,
            TRANSITION_BUFFET_SERVE => STATE_SERVE_SECOND_GUEST,
            TRANSITION_POACHING_ATTEMPT => STATE_POACHING_REACTION,
            TRANSITION_POACHING_RESOLVED => STATE_POACHING_RESOLVED,
        )
    ),

    STATE_NEXT_PLAYER => array(
        "name" => "nextPlayer",
        "description" => '',
        "type" => "game",
        "action" => "stNextPlayer",
        "args" => "argCardsCounters",
        "updateGameProgression" => true,
        "transitions" => array(TRANSITION_PLAYER_TURN => STATE_PLAYER_TURN)
    ),

    STATE_DISCARD => array(
        "name" => "playerDiscardGuest",
        "description" => clienttranslate('${actplayer} must discard guests to keep only one of each suit'),
        "descriptionmyturn" => clienttranslate('${you} must discard guests to keep only one of each suit'),
        "type" => "activeplayer",
        "possibleactions" => array("discardGuests"),
        "transitions" => array(TRANSITION_GUESTS_DISCARDED => STATE_NEXT_PLAYER)
    ),

    STATE_BUFFET_DISCARD => array(
        "name" => "allPlayersDiscardGuest",
        "description" => clienttranslate('Others must discard one satisfied guest'),
        "descriptionmyturn" => clienttranslate('${you}  must discard one of your satisfied guests'),
        "type" => "multipleactiveplayer",
        "action" => "stMakeOtherActive",
        "possibleactions" => array("discardWonGuest"),
        "transitions" => array(TRANSITION_BUFFET_GUEST_DISCARDED => STATE_SERVE_SECOND_GUEST)
    ),

    STATE_SERVE_SECOND_GUEST => array(
        "name" => "serveSecondGuest",
        "description" => clienttranslate('${actplayer} can serve another guest'),
        "descriptionmyturn" => clienttranslate('${you} must serve another guest or pass'),
        "type" => "activeplayer",
        "possibleactions" => array("pass", "serveSecondGuest", "poach"),
        "args" => "argGetPossibleMoves",
        "updateGameProgression" => true,
        "transitions" => array(
            TRANSITION_PASSED => STATE_NEXT_PLAYER, TRANSITION_SECOND_GUEST_SERVED => STATE_NEXT_PLAYER, TRANSITION_DISCARD_GUEST_NEEDED => STATE_DISCARD, TRANSITION_POACHING_ATTEMPT => STATE_POACHING_REACTION,
            TRANSITION_POACHING_RESOLVED => STATE_POACHING_RESOLVED, TRANSITION_END_GAME => STATE_END_GAME
        )
    ),

    STATE_POACHING_REACTION => array(
        "name" => "poachingReaction",
        "description" => clienttranslate('${actplayer} can block poaching attempt'),
        "descriptionmyturn" => clienttranslate('${you} must decide to block poaching attempt or not'),
        "type" => "multipleactiveplayer",
        "action" => "stActivatePoached",
        "possibleactions" => array("blockPoaching", "letPoaching"),
        "args" => "argGetPoachedGuest",
        "updateGameProgression" => true,
        "transitions" => array(TRANSITION_SERVED => STATE_POACHING_RESOLVED,  TRANSITION_POACHING_BLOCKED => STATE_POACHING_RESOLVED)
    ),

    STATE_POACHING_RESOLVED => array(
        "name" => "poachingResolved",
        "type" => "game",
        "action" => "stPoachingResolved",
        "args" => "argCardsCounters",
        "updateGameProgression" => true,
        "transitions" => array(
            TRANSITION_SERVED => STATE_SERVE_SECOND_GUEST, TRANSITION_SECOND_GUEST_SERVED => STATE_NEXT_PLAYER,
            TRANSITION_DISCARD_GUEST_NEEDED => STATE_DISCARD, TRANSITION_END_GAME => STATE_END_GAME, TRANSITION_PLAYER_TURN => STATE_PLAYER_TURN
        )
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
        "updateGameProgression" => true,
        "args" => "argGameEnd"
    )

);
