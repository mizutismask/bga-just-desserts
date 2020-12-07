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
 * justdesserts.view.php
 *
 * This is your "view" file.
 *
 * The method "build_page" below is called each time the game interface is displayed to a player, ie:
 * _ when the game starts
 * _ when a player refreshes the game page (F5)
 *
 * "build_page" method allows you to dynamically modify the HTML generated for the game interface. In
 * particular, you can set here the values of variables elements defined in justdesserts_justdesserts.tpl (elements
 * like {MY_VARIABLE_ELEMENT}), and insert HTML block elements (also defined in your HTML template file)
 *
 * Note: if the HTML of your game interface is always the same, you don't have to place anything here.
 *
 */

require_once(APP_BASE_PATH . "view/common/game.view.php");

class view_justdesserts_justdesserts extends game_view
{
  function getGameName()
  {
    return "justdesserts";
  }
  function build_page($viewArgs)
  {
    // Get players & players number
    $players = $this->game->loadPlayersBasicInfos();
    $players_nbr = count($players);
    $active_player_id = $this->game->publicGetCurrentPlayerId();

    /*********** Place your code below:  ************/


    /*
        
        // Examples: set the value of some element defined in your tpl file like this: {MY_VARIABLE_ELEMENT}

        // Display a specific number / string
        $this->tpl['MY_VARIABLE_ELEMENT'] = $number_to_display;

        // Display a string to be translated in all languages: 
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::_("A string to be translated");

        // Display some HTML content of your own:
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::raw( $some_html_code );
        
        */

    /*
        
        // Example: display a specific HTML block for each player in this game.
        // (note: the block is defined in your .tpl file like this:
        //      <!-- BEGIN myblock --> 
        //          ... my HTML code ...
        //      <!-- END myblock --> 
        

        $this->page->begin_block( "justdesserts_justdesserts", "myblock" );
        foreach( $players as $player )
        {
            $this->page->insert_block( "myblock", array( 
                                                    "PLAYER_NAME" => $player['player_name'],
                                                    "SOME_VARIABLE" => $some_value
                                                    ...
                                                     ) );
        }
        
        */

    $template = self::getGameName() . "_" . self::getGameName();

    // this will make our My Hand text translatable
    $this->tpl['MY_HAND'] = self::_("My hand");
    $this->tpl['REMAINING_DESSERTS'] = self::_("Dessert draw remaining cards");
    $this->tpl['MY_FAVORITES'] = clienttranslate("I have two favorites:");
    $this->tpl['MY_FAVORITE'] = clienttranslate("My favorite is:");
    $this->tpl['NO_FAVORITE'] = clienttranslate("I can’t decide on a favorite!");


    // this will inflate our player block with actual players data
    $this->page->begin_block($template, "player");

    //starting with the active player if he’s not a spectator
    if (key_exists($active_player_id, $players)) {
      $this->page->insert_block("player", array(
        "PLAYER_ID" => $active_player_id,
        "PLAYER_NAME" => $players[$active_player_id]['player_name'],
        "PLAYER_COLOR" => $players[$active_player_id]['player_color'],
        "PLAYER_NAME_WON_CARDS_TITLE" => $players[$active_player_id]['player_name'],
      ));
    }

    //then the other players
    foreach ($players as $player_id => $info) {
      if ($player_id != $active_player_id) {
        $this->page->insert_block("player", array(
          "PLAYER_ID" => $player_id,
          "PLAYER_NAME" => $players[$player_id]['player_name'],
          "PLAYER_COLOR" => $players[$player_id]['player_color'],
          "PLAYER_NAME_WON_CARDS_TITLE" => $players[$player_id]['player_name'],
        ));
      }
    }

    /*********** discards ********/
    $this->tpl['DISCARDED_DESSERTS'] = self::_("Discarded desserts");

    /*********** Do not change anything below this line  ************/
  }
}
