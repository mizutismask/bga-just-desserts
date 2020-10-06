<?php

/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 * 
 * justdesserts.action.php
 *
 * JustDesserts main action entry point
 *
 *
 * In this file, you are describing all the methods that can be called from your
 * user interface logic (javascript).
 *       
 * If you define a method "myAction" here, then you can call it from your javascript code with:
 * this.ajaxcall( "/justdesserts/justdesserts/myAction.html", ...)
 *
 */


class action_justdesserts extends APP_GameAction
{
  // Constructor: please do not modify
  public function __default()
  {
    if (self::isArg('notifwindow')) {
      $this->view = "common_notifwindow";
      $this->viewArgs['table'] = self::getArg("table", AT_posint, true);
    } else {
      $this->view = "justdesserts_justdesserts";
      self::trace("Complete reinitialization of board game");
    }
  }

  // TODO: defines your action entry points there


  /*
    
    Example:
  	
    public function myAction()
    {
        self::setAjaxMode();     

        // Retrieve arguments
        // Note: these arguments correspond to what has been sent through the javascript "ajaxcall" method
        $arg1 = self::getArg( "myArgument1", AT_posint, true );
        $arg2 = self::getArg( "myArgument2", AT_posint, true );

        // Then, call the appropriate method in your game logic, like "playCard" or "myAction"
        $this->game->myAction( $arg1, $arg2 );

        self::ajaxResponse( );
    }
    
    */
  public function drawAction()
  {
    self::setAjaxMode();

    $this->game->draw();

    self::ajaxResponse();
  }

  public function swapAction()
  {
    self::setAjaxMode();
    $cards_id = array();
    $cards_id = self::getArg("cards_id", AT_numberlist, true);
    $cards_id = $this->convertStringToArray($cards_id);
    $this->game->swap($cards_id);

    self::ajaxResponse();
  }

  function convertStringToArray($card_ids_raw)
  {
    // Removing last ';' if exists
    if (substr($card_ids_raw, -1) == ';')
      $card_ids_raw = substr($card_ids_raw, 0, -1);
    if ($card_ids_raw == '')
      $card_ids = array();
    else
      $card_ids = explode(';', $card_ids_raw);
    return $card_ids;
  }
}
