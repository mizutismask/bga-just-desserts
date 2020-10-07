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
 * justdesserts.game.php
 *
 * This is the main file for your game logic.
 *
 * In this PHP file, you are going to defines the rules of the game.
 *
 */


require_once(APP_GAMEMODULE_PATH . 'module/table/table.game.php');


class JustDesserts extends Table
{
    function __construct()
    {
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();

        self::initGameStateLabels(array(
            //    "my_first_global_variable" => 10,
            //    "my_second_global_variable" => 11,
            //      ...
            //    "my_first_game_variant" => 100,
            //    "my_second_game_variant" => 101,
            //      ...
        ));

        $this->dessertcards = self::getNew("module.common.deck");
        $this->dessertcards->init("dessertcard");

        $this->guestcards = self::getNew("module.common.deck");
        $this->guestcards->init("guestcard");
    }

    protected function getGameName()
    {
        // Used for translations and stuff. Please do not modify.
        return "justdesserts";
    }

    /*
        setupNewGame:
        
        This method is called only once, when a new game is launched.
        In this method, you must setup the game according to the game rules, so that
        the game is ready to be played.
    */
    protected function setupNewGame($players, $options = array())
    {
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = self::getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
        $values = array();
        foreach ($players as $player_id => $player) {
            $color = array_shift($default_colors);
            $values[] = "('" . $player_id . "','$color','" . $player['player_canal'] . "','" . addslashes($player['player_name']) . "','" . addslashes($player['player_avatar']) . "')";
        }
        $sql .= implode($values, ',');
        self::DbQuery($sql);
        self::reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        self::reloadPlayersBasicInfos();

        /************ Start the game initialization *****/

        // Init global values with their initial values
        //self::setGameStateInitialValue( 'my_first_global_variable', 0 );

        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)

        // TODO: setup the initial game situation here
        $cards = array();

        self::setupGuestsDeck($players);
        self::setupDessertsDeck($players);

        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();

        /************ End of the game initialization *****/
    }

    /*
        getAllDatas: 
        
        Gather all informations about current game situation (visible by the current player).
        
        The method is called each time the game interface is displayed to a player, ie:
        _ when the game starts
        _ when a player refreshes the game page (F5)
    */
    protected function getAllDatas()
    {
        $result = array();

        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb($sql);

        // TODO: Gather all information about current game situation (visible by player $current_player_id).

        // Cards in player hand
        $result['hand'] = $this->dessertcards->getCardsInLocation('hand', $current_player_id);
        $result['guestsOnTable'] = $this->guestcards->getCardsInLocation('river');
        return $result;
    }

    /*
        getGameProgression:
        
        Compute and return the current game progression.
        The number returned must be an integer beween 0 (=the game just started) and
        100 (= the game is finished or almost finished).
    
        This method is called each time we are in a game state with the "updateGameProgression" property set to true 
        (see states.inc.php)
    */
    function getGameProgression()
    {
        // TODO: compute and return the game progression

        return 0;
    }


    //////////////////////////////////////////////////////////////////////////////
    //////////// Utility functions
    ////////////    

    /*
        In this space, you can put any utility methods useful for your game logic
    */
    function setupGuestsDeck($players)
    {
        $cards = array();
        $i = 1;
        foreach ($this->guests as $guest) {
            $cards[] = array('type' => $guest["name"], 'type_arg' => $i, 'nbr' => 1);
            $i++;
        }
        $this->guestcards->createCards($cards, 'guestDeck');
        $this->guestcards->shuffle('guestDeck');
        $this->pickGuestCardsAndNotifyPlayers(3, $players);
    }

    function setupDessertsDeck($players)
    {
        $cards = array();
        $j = 1;
        foreach ($this->desserts as $dessert) {
            $cards[] = array('type' => $dessert["name"], 'type_arg' => $j, 'nbr' => 1);
            $j++;
        }

        $this->dessertcards->createCards($cards, 'dessertDeck');
        $this->dessertcards->shuffle('dessertDeck');

        foreach ($players as $player_id => $player) {
            $this->pickDessertCardsAndNotifyPlayer(3, $player_id);
        }
    }

    function pickGuestCardsAndNotifyPlayers($nb, $players)
    {
        $cards = $this->guestcards->pickCardsForLocation($nb, 'guestDeck', 'river');
        // Notify player about cards on table
        self::notifyAllPlayers('newRiver', '', array('cards' => $cards));
    }

    function pickDessertCardsAndNotifyPlayer($nb, $player_id)
    {
        $cards = $this->dessertcards->pickCards($nb, 'dessertDeck', $player_id);
        // Notify player about his cards
        self::notifyPlayer($player_id, 'newHand', '', array('cards' => $cards));
    }

    function dessertsAreEnoughForGuest($dessertsFromMaterial, $guestFromMaterial)
    {
        $allTastes = array();
        foreach ($dessertsFromMaterial as $dessert) {
            $allTastes = array_merge($allTastes, $dessert["tastes"]);
        }
        $allTastes = array_unique($allTastes);

        return !array_diff($guestFromMaterial["tastes"], $allTastes);
    }

    function guestDislikesSomething($dessertsFromMaterial, $guestFromMaterial)
    {
        $allTastes = array();
        foreach ($dessertsFromMaterial as $dessert) {
            $allTastes = array_merge($allTastes, $dessert["tastes"]);
        }
        $allTastes = array_unique($allTastes);

        return !in_array($guestFromMaterial["dislike1"], $allTastes) && !in_array($guestFromMaterial["dislike2"], $allTastes);
    }


    //////////////////////////////////////////////////////////////////////////////
    //////////// Player actions
    //////////// 

    /*
        Each time a player is doing some game action, one of the methods below is called.
        (note: each method below must match an input method in justdesserts.action.php)
    */

    /*
    
    Example:

    function playCard( $card_id )
    {
        // Check that this is the player's turn and that it is a "possible action" at this game state (see states.inc.php)
        self::checkAction( 'playCard' ); 
        
        $player_id = self::getActivePlayerId();
        
        // Add your game logic to play a card there 
        ...
        
        // Notify all players about the card played
        self::notifyAllPlayers( "cardPlayed", clienttranslate( '${player_name} plays ${card_name}' ), array(
            'player_id' => $player_id,
            'player_name' => self::getActivePlayerName(),
            'card_name' => $card_name,
            'card_id' => $card_id
        ) );
          
    }
    
    */
    function draw()
    {
        $player_id = self::getActivePlayerId();

        // Make sure this is an accepted action
        if (self::checkAction('draw')) {
            $this->pickDessertCardsAndNotifyPlayer(1, $player_id);
        }

        self::notifyAllPlayers('draw', clienttranslate('${player_name} draws a dessert'), array('player_name' => self::getActivePlayerName()));

        $this->gamestate->nextState('draw'); //computes the next state when draw is given to the current state.
    }

    function swap($cards_id)
    {
        $player_id = self::getActivePlayerId();
        $cards_nb = sizeof($cards_id);

        // Make sure this is an accepted action
        if (self::checkAction('swap')) {
            $this->dessertcards->moveCards($cards_id, 'dessertDiscard');
            $new_cards = $this->dessertcards->pickCards($cards_nb, 'dessertDeck', $player_id);
            // Notify player about his cards
            //$playerCards = $this->dessertcards->getCardsInLocation('hand', $player_id);
            self::notifyPlayer($player_id, 'newHand', '', array('cards' => $new_cards));
        }

        self::notifyAllPlayers('swap', clienttranslate('${player_name} swaps ${cards_nb} cards'), array('player_name' => self::getActivePlayerName(), 'cards_nb' => $cards_nb));

        $this->gamestate->nextState('swap'); //computes the next state when draw is given to the current state.
    }

    function serve($guest_id, $cards_id)
    {
        $player_id = self::getActivePlayerId();
        $guest = $this->guestcards->getCard($guest_id);
        $guestFromMaterial = $this->guests[$guest["type_arg"]];

        $desserts = $this->dessertcards->getCards($cards_id);
        $dessertsFromMaterial = array();
        foreach ($desserts as $dessert) {
            $dessertsFromMaterial[] = $this->desserts[$dessert["type_arg"]];
        }

        // Make sure this is an accepted action
        if (self::checkAction('serve')) {
            if (self::dessertsAreEnoughForGuest($dessertsFromMaterial, $guestFromMaterial)) {
                if (self::guestDislikesSomething($dessertsFromMaterial, $guestFromMaterial)) {

                    $this->dessertcards->moveCards($cards_id, 'dessertDiscard');
                    $this->guestcards->moveCard($guest_id, 'won', $player_id);

                    self::notifyAllPlayers('serve', clienttranslate('${player_name} serves ${guest_name}'), array('player_name' => self::getActivePlayerName(), 'guest_name' => $guestFromMaterial["name"]));
                    self::notifyAllPlayers('guestsRemoved', '', array('cards' => [$guest]));

                    if (false) {
                        //if the guest got his favorite, there’s a tip
                        $new_cards = $this->dessertcards->pickCards(1, 'dessertDeck', $player_id);
                        // Notify player about his tip
                        self::notifyPlayer($player_id, 'newHand', '', array('cards' => $new_cards));
                    }
                } else {
                    throw new BgaUserException(self::_("This guest refuses to eat one of the ingredients you provided"));
                }
            } else {
                throw new BgaUserException(self::_("This guest is not satisfied with your desserts"));
            }
        }


        $this->gamestate->nextState('serve'); //computes the next state when draw is given to the current state.
    }



    //////////////////////////////////////////////////////////////////////////////
    //////////// Game state arguments
    ////////////

    /*
        Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
        These methods function is to return some additional information that is specific to the current
        game state.
    */

    /*
    
    Example for game state "MyGameState":
    
    function argMyGameState()
    {
        // Get some values from the current game situation in database...
    
        // return values:
        return array(
            'variable1' => $value1,
            'variable2' => $value2,
            ...
        );
    }    
    */

    //////////////////////////////////////////////////////////////////////////////
    //////////// Game state actions
    ////////////

    /*
        Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
        The action method of state X is called everytime the current game state is set to X.
    */

    /*
    
    Example for game state "MyGameState":

    function stMyGameState()
    {
        // Do some stuff ...
        
        // (very often) go to another gamestate
        $this->gamestate->nextState( 'some_gamestate_transition' );
    }    
    */
    function stNextPlayer()
    {
        $players = self::loadPlayersBasicInfos();
        $player_id = self::activeNextPlayer();
        $this->pickGuestCardsAndNotifyPlayers(1, $players);
        $this->pickDessertCardsAndNotifyPlayer(1, $player_id);

        self::notifyAllPlayers('playerTurn', clienttranslate('New turn : ${player_name} draws a dessert and a guest'), array('player_name' => self::getActivePlayerName()));

        self::giveExtraTime($player_id);
        $this->gamestate->nextState('playerTurn');
    }
    //////////////////////////////////////////////////////////////////////////////
    //////////// Zombie
    ////////////

    /*
        zombieTurn:
        
        This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
        You can do whatever you want in order to make sure the turn of this player ends appropriately
        (ex: pass).
        
        Important: your zombie code will be called when the player leaves the game. This action is triggered
        from the main site and propagated to the gameserver from a server, not from a browser.
        As a consequence, there is no current player associated to this action. In your zombieTurn function,
        you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message. 
    */

    function zombieTurn($state, $active_player)
    {
        $statename = $state['name'];

        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState("zombiePass");
                    break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive($active_player, '');

            return;
        }

        throw new feException("Zombie mode not supported at this game state: " . $statename);
    }

    ///////////////////////////////////////////////////////////////////////////////////:
    ////////// DB upgrade
    //////////

    /*
        upgradeTableDb:
        
        You don't have to care about this until your game has been published on BGA.
        Once your game is on BGA, this method is called everytime the system detects a game running with your old
        Database scheme.
        In this case, if you change your Database scheme, you just have to apply the needed changes in order to
        update the game database and allow the game to continue to run with your new version.
    
    */

    function upgradeTableDb($from_version)
    {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345

        // Example:
        //        if( $from_version <= 1404301345 )
        //        {
        //            // ! important ! Use DBPREFIX_<table_name> for all tables
        //
        //            $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
        //            self::applyDbUpgradeToAllDB( $sql );
        //        }
        //        if( $from_version <= 1405061421 )
        //        {
        //            // ! important ! Use DBPREFIX_<table_name> for all tables
        //
        //            $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
        //            self::applyDbUpgradeToAllDB( $sql );
        //        }
        //        // Please add your future database scheme changes here
        //
        //


    }
}
