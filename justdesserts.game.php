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
            "last_discarded_guest_id" => 10,
            //    "my_first_global_variable" => 10,
            //    "my_second_global_variable" => 11,
            //      ...
            //    "my_first_game_variant" => 100,
            //    "my_second_game_variant" => 101,
            //      ...
        ));

        $this->dessertcards = self::getNew("module.common.deck");
        $this->dessertcards->init("dessertcard");
        $this->dessertcards->autoreshuffle = true;


        $this->guestcards = self::getNew("module.common.deck");
        $this->guestcards->init("guestcard");
        $this->guestcards->autoreshuffle = true;
        $this->guestcards->autoreshuffle_trigger = array('obj' => $this, 'method' => 'deckAutoReshuffle');
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
        self::setGameStateInitialValue('last_discarded_guest_id', 0);

        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        self::initStat('player', 'guests_number', 0);  // Init a player statistics (for all players)
        self::initStat('player', 'turns_number', 0);
        self::initStat('player', 'player_tips_number', 0);
        self::initStat('player', 'player_swaps_number', 0);

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

        $result['guestCards'] = $this->guests;

        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb($sql);

        // TODO: Gather all information about current game situation (visible by player $current_player_id).

        // Cards in player hand
        $result['hand'] = $this->dessertcards->getCardsInLocation('hand', $current_player_id);
        $result['guestsOnTable'] = $this->improveGuestCards($this->guestcards->getCardsInLocation('river'));

        //won cards for each player
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player) {
            $result['won'][$player["player_id"]] = $this->guestcards->getCardsInLocation('won', $player["player_id"]);
        }

        //last discarded guest
        $result['lastDiscardedGuest'] = $this->guestcards->getCardOnTop('discard');

        $result['discardedDesserts'] = $this->dessertcards->getCardsInLocation('discard');

        //cards in hand number
        $result['counters'] = $this->argNbrCardsInHand();
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
        $players = self::loadPlayersBasicInfos();
        $progressionByPlayerId = array();

        foreach ($players as $player_id => $player) {
            $cards = $this->guestcards->getCardsInLocation('won', $player_id);
            $differentColors = $this->countCardsForObjective5Differents($cards);
            $suite = $this->countCardsForObjective3OfAKind($cards);

            $prog = $differentColors * 100 / 5;
            if ($suite == 2) {
                $prog = max($suite * 100 / 3, $prog);
            }
            $progressionByPlayerId[$player_id] = $prog;
        }
        return max($progressionByPlayerId);
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
            $cards[] = array('type' => $guest["nameId"], 'type_arg' => $i, 'nbr' => 1);
            $i++;
        }
        $this->guestcards->createCards($cards, 'deck');
        $this->dessertcards->shuffle('deck');
        $this->pickGuestCardsAndNotifyPlayers(3, $players);
    }

    function setupDessertsDeck($players)
    {
        $cards = array();
        $j = 1;
        foreach ($this->desserts as $dessert) {
            $cards[] = array('type' => $dessert["nameId"], 'type_arg' => $j, 'nbr' => 1);
            $j++;
        }
        $this->dessertcards->createCards($cards, 'deck');
        $this->dessertcards->shuffle('deck');

        foreach ($players as $player_id => $player) {
            $this->pickDessertCardsAndNotifyPlayer(3, $player_id);
        }
    }

    /** Reset the last discarded guest on top of discard. */
    function deckAutoReshuffle()
    {
        $card_id = self::getGameStateValue('last_discarded_guest_id');
        if ($card_id) {
            $card = $this->guestcards->getCard($card_id);
            //if card was not won since
            if ($card["location"] != "won") {
                $this->playGuestCards([$card_id]);
            }
        }
    }

    function pickGuestCardsAndNotifyPlayers($nb, $players)
    {
        $cards = $this->guestcards->pickCardsForLocation($nb, 'deck', 'river');
        // Notify player about cards on table
        self::notifyAllPlayers('newRiver', '', array('cards' => $this->improveGuestCards($cards)));
        return $cards;
    }

    function pickDessertCardsAndNotifyPlayer($nb, $player_id)
    {
        $cards = $this->dessertcards->pickCards($nb, 'deck', $player_id);

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

        return !in_array($guestFromMaterial["dislike1"], $allTastes) || array_key_exists("dislike2", $guestFromMaterial) && !in_array($guestFromMaterial["dislike2"], $allTastes);
    }

    function isGuestGivenHisFavourite($dessertsFromMaterial, $guestFromMaterial)
    {
        $allDessertNames = array();
        foreach ($dessertsFromMaterial as $dessert) {
            $allDessertNames[] = $dessert["nameId"];
        }

        return in_array($guestFromMaterial["favourite1"], $allDessertNames)
            || $guestFromMaterial["favourite2"] && in_array($guestFromMaterial["favourite2"], $allDessertNames);
    }

    function argNbrCardsInHand()
    {
        $players = self::getObjectListFromDB("SELECT player_id id FROM player", true);
        $counters = array();
        for ($i = 0; $i < ($this->getPlayersNumber()); $i++) {
            $counters['cards_count_' . $players[$i]] = array('counter_name' => 'cards_count_' . $players[$i], 'counter_value' => 0);
        }
        $cards_in_hand = $this->dessertcards->countCardsByLocationArgs('hand');
        foreach ($cards_in_hand as $player_id => $cards_nbr) {
            $counters['cards_count_' . $player_id]['counter_value'] = $cards_nbr;
        }
        return $counters;
    }


    /**
     * True if there is several guests with the same color.
     */
    function guestsNeedsToBeDiscarded()
    {
        $cards = $this->guestcards->getCardsInLocation('river');
        $guests = $this->getGuestsFromMaterialByCards($cards);
        $allSuits = array();
        foreach ($guests as $guest) {
            $allSuits[] = $guest["color"];
        }
        return count($allSuits) != count(array_unique($allSuits));
    }

    /*
     When the guest is satisfied, it goes to the won pile of the player and used desserts are discarded.
     The player can have a tip.
     */
    function doSatisfiedGuestActions($dessert_cards_id, $guest, $guestFromMaterial, $dessertsFromMaterial)
    {
        $player_id = self::getActivePlayerId();
        $this->playDessertCards($dessert_cards_id);
        $fromDiscard = $guest["location"] == "discard";
        self::dump("guest", $guest);
        $this->guestcards->moveCard($guest["id"], 'won', $player_id);
        self::incStat(1, "guests_number", $player_id);

        self::notifyAllPlayers('newGuestWon', clienttranslate('${player_name} serves ${guest_name}'), array(
            'player_name' => self::getActivePlayerName(),
            'guest_name' => $guestFromMaterial["name"],
            'card' => $guest,
            'player_id' => $player_id,
            'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop('discard'),
            'fromDiscard' => $fromDiscard,
            'discardedDesserts' => $this->getDessertCardsFromIds($dessert_cards_id),
        ));

        //if the guest got his favorite, there’s a tip
        if ($this->isGuestGivenHisFavourite($dessertsFromMaterial, $guestFromMaterial)) {
            $new_cards = $this->dessertcards->pickCards(1, 'deck', $player_id);
            // Notify player about his tip
            self::notifyPlayer($player_id, 'newHand', '', array('cards' => $new_cards));
            self::incStat(1, "player_tips_number", $player_id);
            //notify other that he got one tip
            self::notifyAllPlayers('serve', clienttranslate('${player_name} gets a new dessert card as a tip'), array('player_name' => self::getActivePlayerName()));
        }

        //getting data to check if the active player hit a winning requirement
        $woncards = $this->guestcards->getCardsInLocation('won', $player_id);

        //5 different colors or 3 of the same one
        if ($this->countCardsForObjective5Differents($woncards) == 5 || $this->countCardsForObjective3OfAKind($woncards) == 3) {
            //victory
            $this->updateScores($player_id);
            $this->gamestate->nextState(TRANSITION_END_GAME);
        } else if ($this->gameCanNotBeWonAnyWonAnymore()) {
            $this->updateScoresWithoutWinner();
            $this->gamestate->nextState(TRANSITION_END_GAME);
        }
    }

    function gameCanNotBeWonAnyWonAnymore()
    {
        return $this->guestcards->countCardInLocation("river") == 0
            && $this->guestcards->countCardInLocation("deck") == 0
            && $this->guestcards->countCardInLocation("discard") == 0;
    }

    function concatenateColorsFromCards($cards)
    {
        $guests = $this->getGuestsFromMaterialByCards($cards);
        $allSuits = array();
        foreach ($guests as $guest) {
            $allSuits[] = $guest["color"];
        }
        return $allSuits;
    }

    function countCardsForObjective5Differents($woncards)
    {
        $allSuits = $this->concatenateColorsFromCards($woncards);
        return count(array_unique($allSuits));
    }

    function countCardsForObjective3OfAKind($woncards)
    {
        $allSuits = $this->concatenateColorsFromCards($woncards);
        $valuesOccurrences = array_count_values($allSuits);
        self::dump("valuesOccurrences", $valuesOccurrences);

        return $valuesOccurrences ? max($valuesOccurrences) : 0;
    }

    function publicGetCurrentPlayerId()
    {
        return self::getCurrentPlayerId();
    }


    /**
     * Each player get 1 point per satisfied guest + 1 point per pair
     */
    function updateScoresWithoutWinner()
    {
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player_id => $player) {
            $woncards = $this->guestcards->getCardsInLocation('won', $player_id);
            $allSuits = $this->concatenateColorsFromCards($woncards);
            $valuesOccurrences = array_count_values($allSuits);
            $score = 0;
            foreach ($valuesOccurrences as $color => $occ) {
                $score += $occ;
                if ($occ == 2) {
                    $score++;
                }
            }
            $this->updateScore($player_id, $score);
        }
        $this->reloadScoresAndNotify();
    }

    function updateScores($winner_id)
    {
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player_id => $player) {
            $score = 0;
            if ($player_id == $winner_id) {
                $score = 100;
            }
            $this->updateScore($player_id, $score);
        }
        $this->reloadScoresAndNotify();
    }

    function updateScore($player_id, $score)
    {
        $sql = "UPDATE player set player_score=" . $score . " where player_id=" . $player_id;
        self::DbQuery($sql);
    }

    function reloadScoresAndNotify()
    {
        $playerInfo = self::getCollectionFromDB("SELECT player_id, player_score FROM player");

        // Update the scores on the client side
        self::notifyAllPlayers('updateScore', '', array(
            'players' => $playerInfo
        ));
    }

    function improveGuestCards($cards)
    {
        foreach ($cards as $card) {
            $materialCard = $this->getGuestFromMaterialFromCard($card);
            $card["favourite1Tr"] = $materialCard["name"];
        }
        self::dump("*********improved",  $cards);
        return $cards;
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
        $this->goToDiscardIfNeededOrGoTo(TRANSITION_DRAWN);
    }

    function swap($cards_id)
    {
        // Make sure this is an accepted action
        if (self::checkAction('swap')) {
            $player_id = self::getActivePlayerId();
            $cards_nb = sizeof($cards_id);

            $this->playDessertCards($cards_id);
            $new_cards = $this->dessertcards->pickCards($cards_nb, 'deck', $player_id);
            // Notify player about his cards
            self::notifyPlayer($player_id, 'newHand', '', array('cards' => $new_cards));
            self::incStat(1, "player_swaps_number", $player_id);

            $discardedDesserts = $this->getDessertCardsFromIds($cards_id);
            self::notifyAllPlayers('discardedDesserts', clienttranslate('${player_name} swaps ${cards_nb} cards'), array(
                'player_name' => self::getActivePlayerName(),
                'player_id' => $player_id,
                'cards_nb' => $cards_nb,
                'discardedDesserts' => $discardedDesserts,

            ));
        }
        $this->goToDiscardIfNeededOrGoTo(TRANSITION_SWAPPED);
    }

    function discardGuests($cards_id)
    {
        $cards_nb = sizeof($cards_id);

        // Make sure this is an accepted action
        if (self::checkAction('discardGuests')) {

            $cards = $this->guestcards->getCardsInLocation('river');
            $guests_in_river = $this->getGuestsFromMaterialByCards($cards);

            $guests_to_remove = $this->guestcards->getCards($cards_id);
            $guests_to_remove_from_material = $this->getGuestsFromMaterialByIds($cards_id);

            foreach ($guests_in_river as $guest) {
                $allSuits[] = $guest["color"];
            }

            $valuesOccurrences = array_count_values($allSuits);
            $pbOccurrences = array_filter($valuesOccurrences, function ($occurrences) {
                return $occurrences > 1;
            });

            $cardsFromOtherColors = false;
            foreach ($guests_to_remove_from_material as $guest_to_remove) {
                $color = $guest_to_remove['color'];
                self::trace("color: $color");
                self::dump("pbOccurrences", $pbOccurrences);

                $valuesOccurrences[$color] += -1;
                if (!array_key_exists($color, $pbOccurrences)) {
                    self::trace("$color not found in problematic occurrences");
                    $cardsFromOtherColors = true;
                }
            }
            //there is only one card of each and no extra card is discarded
            if (!$cardsFromOtherColors && max($valuesOccurrences) == 1 && min($valuesOccurrences) >= 0) {
                $this->playGuestCards($cards_id);
                self::notifyAllPlayers(
                    'discardedGuests',
                    clienttranslate('${player_name} discards ${cards_nb} guest(s)'),
                    array(
                        'player_name' => self::getActivePlayerName(),
                        'cards_nb' => $cards_nb,
                        'cards' => $guests_to_remove,
                        'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop('discard')
                    )
                );
                $this->gamestate->nextState(TRANSITION_GUESTS_DISCARDED);
            } else {
                throw new BgaUserException(self::_("Dicard only guests needed to keep one of each suite at most"));
            }
        }
    }

    /**
     * Takes an array and returns an array of duplicate items
     */
    function get_duplicates($array)
    {
        return array_unique(array_diff_assoc($array, array_unique($array)));
    }

    function playGuestCards($cards_id)
    {
        $last_card_id = null;
        foreach ($cards_id as $card_id) {
            $this->guestcards->playCard($card_id);
            $last_card_id =  $card_id;
        }
        self::setGameStateValue('last_discarded_guest_id', $last_card_id);
    }

    function playDessertCards($cards_id)
    {
        foreach ($cards_id as $card_id) {
            //moves the card to the discard
            $this->dessertcards->playCard($card_id);
        }
    }

    private function getGuestFromMaterial($guest_id)
    {
        $guest = $this->guestcards->getCard($guest_id);
        return $this->guests[$guest["type_arg"]];
    }

    private function getGuestFromMaterialFromCard($guest)
    {
        return $this->guests[$guest["type_arg"]];
    }

    private function getGuestsFromMaterialByCards($guests)
    {
        $guestsFromMaterial = array();
        foreach ($guests as $guest) {
            $guestsFromMaterial[] = $this->guests[$guest["type_arg"]];
        }
        return $guestsFromMaterial;
    }

    private function getGuestsFromMaterialByIds($guest_ids)
    {
        $guests = $this->guestcards->getCards($guest_ids);
        return $this->getGuestsFromMaterialByCards($guests);
    }

    function getDessertCardsFromIds($cards_id)
    {
        $cards = array();
        foreach ($cards_id as $card_id) {
            $cards[] = $this->dessertcards->getCard($card_id);
        }
        return $cards;
    }

    private function serve($guest_id, $cards_id, $action, $nextState)
    {
        $guest = $this->guestcards->getCard($guest_id);
        $guestFromMaterial = $this->guests[$guest["type_arg"]];

        $desserts = $this->dessertcards->getCards($cards_id);
        $dessertsFromMaterial = array();
        foreach ($desserts as $dessert) {
            $dessertsFromMaterial[] = $this->desserts[$dessert["type_arg"]];
        }

        // Make sure this is an accepted action
        if (self::checkAction($action)) {
            if (self::dessertsAreEnoughForGuest($dessertsFromMaterial, $guestFromMaterial)) {
                if (self::guestDislikesSomething($dessertsFromMaterial, $guestFromMaterial)) {
                    $this->doSatisfiedGuestActions($cards_id, $guest, $guestFromMaterial, $dessertsFromMaterial);
                } else {
                    throw new BgaUserException(self::_("This guest refuses to eat one of the ingredients you provided"));
                }
            } else {
                throw new BgaUserException(self::_("This guest is not satisfied with your desserts"));
            }
        }

        if ($this->guestsNeedsToBeDiscarded() && $action == "serveSecondGuest") {
            $this->gamestate->nextState(TRANSITION_DISCARD_GUEST_NEEDED);
        } else {
            $this->gamestate->nextState($nextState);
        }
    }

    function serveFirstGuest($guest_id, $cards_id)
    {
        self::serve($guest_id, $cards_id, 'serve', TRANSITION_SERVED);
    }

    function serveSecondGuest($guest_id, $cards_id)
    {
        self::serve($guest_id, $cards_id, 'serveSecondGuest', TRANSITION_SECOND_GUEST_SERVED);
    }

    function goToDiscardIfNeededOrGoTo($nextState)
    {
        if ($this->guestsNeedsToBeDiscarded()) {
            $this->gamestate->nextState(TRANSITION_DISCARD_GUEST_NEEDED);
        } else {
            $this->gamestate->nextState($nextState);
        }
    }

    function pass()
    {
        if (self::checkAction("pass")) {
            $this->goToDiscardIfNeededOrGoTo(TRANSITION_PASSED);
        }
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

        if (!self::isZombie($player_id)) {
            self::incStat(1, "turns_number", $player_id);

            $pickedGuests = $this->pickGuestCardsAndNotifyPlayers(1, $players);
            $this->pickDessertCardsAndNotifyPlayer(1, $player_id);

            if ($pickedGuests) {
                $guestName = $this->getGuestFromMaterial($pickedGuests[0]["id"])["name"];
                self::notifyAllPlayers(
                    'playerTurn',
                    clienttranslate('New turn : ${player_name} draws a dessert and ${guestName}'),
                    array(
                        'player_name' => self::getActivePlayerName(),
                        "guestName" => $guestName,
                    )
                );
            } else {
                self::notifyAllPlayers(
                    'playerTurn',
                    clienttranslate('New turn : ${player_name} draws a dessert. There’s no more guests on the pile.'),
                    array(
                        'player_name' => self::getActivePlayerName(),
                    )
                );
            }


            self::giveExtraTime($player_id);
        }

        $this->gamestate->nextState(TRANSITION_PLAYER_TURN);
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
    function isZombie($player_id)
    {
        return self::getUniqueValueFromDB("SELECT player_zombie FROM player WHERE player_id=" . $player_id);
    }

    function zombieTurn($state, $active_player)
    {
        $statename = $state['name'];

        if ($state['type'] === "activeplayer") {

            switch ($statename) {
                case "playerTurn":
                    //draws a dessert and discards it
                    $this->dessertcards->pickCardForLocation('deck', "discard");
                    $this->gamestate->nextState(TRANSITION_DRAWN);
                    break;
                case "serveSecondGuest":
                    $this->gamestate->nextState(TRANSITION_PASSED);
                    break;
                case "playerDiscardGuest":
                    $this->zombieDiscard();
                    $this->gamestate->nextState(TRANSITION_GUESTS_DISCARDED);
                    break;
            }
            return;
        }
        throw new feException("Zombie mode not supported at this game state: " . $statename);
    }


    function zombieDiscard()
    {
        if ($this->guestsNeedsToBeDiscarded()) {
            $river_cards = $this->guestcards->getCardsInLocation('river');
            $allSuits = $this->concatenateColorsFromCards($river_cards);
            $valuesOccurrences = array_count_values($allSuits);
            $pbOccurrences = array_filter($valuesOccurrences, function ($occurrences) {
                return $occurrences > 1;
            });
            $guests_to_remove = array();
            do {
                foreach ($pbOccurrences as $pbColor => $occ) {
                    $removed = false;
                    foreach ($river_cards as $river_card) {
                        if (!$removed) {
                            $cardFromMaterial = $this->getGuestFromMaterialFromCard($river_card);
                            if ($cardFromMaterial["color"] == $pbColor) {
                                $this->playGuestCards([$river_card["id"]]);
                                $guests_to_remove[] = $river_card;
                                $removed = true;
                                break;
                            }
                        }
                    }
                }
            } while ($this->guestsNeedsToBeDiscarded());

            self::notifyAllPlayers(
                'discardedGuests',
                clienttranslate('The player who left discards ${cards_nb} guest(s)'),
                array(
                    'cards_nb' => count($guests_to_remove),
                    'cards' => $guests_to_remove,
                    'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop('discard')
                )
            );
        }
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
