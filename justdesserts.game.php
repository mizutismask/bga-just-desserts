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
require_once("modules/php/constants.inc.php");

if (!defined('DECK_LOC_DECK')) {
    // constants for deck locations
    define("DECK_LOC_DECK", "deck");
    define("DECK_LOC_RIVER", "river");
    define("DECK_LOC_DISCARD", "discard");
    define("DECK_LOC_HAND", "hand");
    define("DECK_LOC_WON", 'won');
    define("DECK_LOC_BLOCK", 'block');

    // constants for notifications
    define("NOTIF_DISCARDED_GUESTS", "discardedGuests");
    define("NOTIF_DISCARDED_DESSERTS", "discardedDesserts");
    define("NOTIF_PLAYER_TURN", "playerTurn");
    define("NOTIF_UPDATE_SCORE", "updateScore");
    define("NOTIF_NEW_RIVER", "newRiver");
    define("NOTIF_NEW_HAND", "newHand");
    define("NOTIF_NEW_GUEST_WON", "newGuestWon");
    define("NOTIF_GUEST_POACHED", "guestPoached");
    define("NOTIF_POACHING_BLOCKED", "poachingBlocked");
    define("NOTIF_UPDATE_CARDS_NB", "updateCardsNb");

    // constants for game states
    define('GS_LAST_DISCARDED_GUEST_ID', "last_discarded_guest_id");
    define('GS_OPENING_BUFFET_PLAYER', "opening_buffet_player");
    define('GS_POACHING_PLAYER', "poaching_player");
    define('GS_POACHED_PLAYER', "poached_player");
    define('GS_ALREADY_POACHED_THIS_TURN', "already_poached_this_turn");
    define('GS_GUESTS_SERVED_THIS_TURN', "guests_served_this_turn");
    define('GS_POACHED_GUEST_ID', "guest_poached_id");
}

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
            GS_LAST_DISCARDED_GUEST_ID => 10,
            GS_OPENING_BUFFET_PLAYER => 11,
            GS_POACHING_PLAYER => 12,
            GS_ALREADY_POACHED_THIS_TURN => 13,
            GS_GUESTS_SERVED_THIS_TURN => 14,
            GS_POACHED_PLAYER => 15,
            GS_POACHED_GUEST_ID => 16,

            "type_of_rules" => TYPE_OF_RULES,
            "opening_a_buffet" => OPENING_BUFFET,
            "poaching" => POACHING,
            "expansion_bacon" => EXPANSION_BACON,
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
        self::setGameStateInitialValue(GS_LAST_DISCARDED_GUEST_ID, 0);
        self::setGameStateInitialValue(GS_OPENING_BUFFET_PLAYER, 0);
        self::setGameStateInitialValue(GS_POACHING_PLAYER, 0);
        self::setGameStateInitialValue(GS_ALREADY_POACHED_THIS_TURN, 0);
        self::setGameStateInitialValue(GS_GUESTS_SERVED_THIS_TURN, 0);
        self::setGameStateInitialValue(GS_POACHED_PLAYER, 0);
        self::setGameStateInitialValue(GS_POACHED_GUEST_ID, 0);

        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        self::initStat('player', 'guests_number', 0);  // Init a player statistics (for all players)
        self::initStat('player', 'turns_number', 0);
        self::initStat('player', 'player_tips_number', 0);
        self::initStat('player', 'player_swaps_number', 0);
        self::initStat('player', 'opened_buffets_number', 0);
        self::initStat('player', 'poaching_number', 0);
        self::initStat('player', 'blocking_number', 0);

        self::setupGuestsDeck($players);
        self::setupDessertsDeck($players);

        // Activate first player 
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
        //won cards for each player
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player) {
            $result['won'][$player["player_id"]] = $this->guestcards->getCardsInLocation(DECK_LOC_WON, $player["player_id"]);
        }

        // Gather all information about current game situation (visible by player $current_player_id).
        $result['hand'] = $this->dessertcards->getCardsInLocation(DECK_LOC_HAND, $current_player_id);
        $result['guestsOnTable'] = $this->guestcards->getCardsInLocation(DECK_LOC_RIVER);
        $result['lastDiscardedGuest'] = $this->guestcards->getCardOnTop(DECK_LOC_DISCARD);
        $result['discardedDesserts'] = $this->dessertcards->getCardsInLocation(DECK_LOC_DISCARD);
        $result['counters'] = $this->argNbrCardsInHand();
        $result['isOpeningABuffetOn'] = $this->isOpeningABuffetOn();
        $result['isPoachingOn'] = $this->isPoachingOn();
        $result['isExpansionBaconOn'] = $this->isExpansionBaconOn();
        $result['cardsAvailable']["desserts"] = array(
            array(
                "from" => 1,
                "to" => 76,
            ),
        );
        $result['cardsAvailable']["guests"] = array(
            array(
                "from" => 1,
                "to" => 24,
            ),
        );

        if ($this->isExpansionBaconOn()) {
            $result['cardsAvailable']["desserts"][] = array(
                "from" => 77,
                "to" => 82,
            );
            $result['cardsAvailable']["guests"][] = array(
                "from" => 25,
                "to" => 28,
            );
        }
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
            $cards = $this->guestcards->getCardsInLocation(DECK_LOC_WON, $player_id);
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
        $this->guestcards->createCards($cards, DECK_LOC_DECK);
        $this->guestcards->shuffle(DECK_LOC_DECK);
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
        $this->dessertcards->createCards($cards, DECK_LOC_DECK);
        $this->dessertcards->shuffle(DECK_LOC_DECK);

        foreach ($players as $player_id => $player) {
            $this->pickDessertCardsAndNotifyPlayer(3, $player_id);
        }
    }

    /** Reset the last discarded guest on top of discard. */
    function deckAutoReshuffle()
    {
        $card_id = self::getGameStateValue(GS_LAST_DISCARDED_GUEST_ID);
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
        $cards = $this->guestcards->pickCardsForLocation($nb, DECK_LOC_DECK, DECK_LOC_RIVER);
        // Notify player about cards on table
        self::notifyAllPlayers(NOTIF_NEW_RIVER, '', array('cards' => $cards));
        return $cards;
    }

    function pickDessertCardsAndNotifyPlayer($nb, $player_id)
    {
        $cards = $this->dessertcards->pickCards($nb, DECK_LOC_DECK, $player_id);

        // Notify player about his cards
        self::notifyPlayer($player_id, NOTIF_NEW_HAND, '', array('cards' => $cards));

        self::notifyAllPlayers(NOTIF_UPDATE_CARDS_NB, "", array(
            'counters' => $this->argNbrCardsInHand(),
        ));
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
        if ($this->startsWith($guestFromMaterial["favourite1"], "ANYTHING_WITH_")) {
            $splitted = explode("_", $guestFromMaterial["favourite1"]);
            $flavour = $splitted[count($splitted) - 1];

            foreach ($dessertsFromMaterial as $dessert) {
                if (in_array($flavour, $dessert["tastes"])) {
                    return true;
                }
            }
        } else {
            $allDessertNames = $this->concatenateFieldValues($dessertsFromMaterial, "nameId");

            return in_array($guestFromMaterial["favourite1"], $allDessertNames)
                || $guestFromMaterial["favourite2"] && in_array($guestFromMaterial["favourite2"], $allDessertNames);
        }
    }

    /**
     * True if there is several guests with the same color.
     */
    function guestsNeedsToBeDiscarded()
    {
        $cards = $this->guestcards->getCardsInLocation(DECK_LOC_RIVER);
        $allSuits = $this->concatenateColorsFromCards($cards);
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
        $fromDiscard = $guest["location"] == DECK_LOC_DISCARD;
        $this->guestcards->moveCard($guest["id"], DECK_LOC_WON, $player_id);
        self::incStat(1, "guests_number", $player_id);
        self::incGameStateValue(GS_GUESTS_SERVED_THIS_TURN, 1);

        self::notifyAllPlayers(NOTIF_NEW_GUEST_WON, clienttranslate('${player_name} serves ${guest_name}'), array(
            'player_name' => self::getActivePlayerName(),
            'guest_name' => $guestFromMaterial["name"],
            'card' => $guest,
            'player_id' => $player_id,
            'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop(DECK_LOC_DISCARD),
            'fromDiscard' => $fromDiscard,
            'discardedDesserts' => $this->getDessertCardsFromIds($dessert_cards_id),
            'counters' => $this->argNbrCardsInHand(),
        ));
        $this->giveTipIfNeeded($dessertsFromMaterial, $guestFromMaterial, $player_id);
        $this->checkIfEndOfGame($player_id);
    }

    function checkIfEndOfGame($player_id)
    {
        //getting data to check if the active player hit a winning requirement
        $woncards = $this->guestcards->getCardsInLocation(DECK_LOC_WON, $player_id);

        //5 different colors or 3 of the same one
        if ($this->countCardsForObjective5Differents($woncards) == 5 || $this->countCardsForObjective3OfAKind($woncards) == 3) {
            //victory
            $this->updateScores($player_id);
            $this->gamestate->nextState(TRANSITION_END_GAME);
        } else if ($this->gameCanNotBeFinished()) {
            $this->updateScoresWithAlternativeEnd();
            $this->gamestate->nextState(TRANSITION_END_GAME);
        }
    }

    function gameCanNotBeFinished()
    {
        return $this->guestcards->countCardInLocation(DECK_LOC_RIVER) == 0
            && $this->guestcards->countCardInLocation(DECK_LOC_DECK) == 0
            && $this->guestcards->countCardInLocation(DECK_LOC_DISCARD) == 0;
    }

    function giveTipIfNeeded($dessertsFromMaterial, $guestFromMaterial, $player_id)
    {
        //if the guest got his favorite, there’s a tip
        if ($this->isGuestGivenHisFavourite($dessertsFromMaterial, $guestFromMaterial)) {
            $new_cards = $this->dessertcards->pickCards(1, DECK_LOC_DECK, $player_id);
            // Notify player about his tip
            self::notifyPlayer($player_id, NOTIF_NEW_HAND, '', array('cards' => $new_cards));
            self::incStat(1, "player_tips_number", $player_id);
            //notify other that he got one tip
            self::notifyAllPlayers(NOTIF_UPDATE_CARDS_NB, clienttranslate('${player_name} gets a new dessert card as a tip'), array(
                'player_name' => $this->getPlayerName($player_id),
                'counters' => $this->argNbrCardsInHand(),
            ));
        }
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

    function concatenateFieldValues($arr, $field)
    {
        $concatenated = array();
        foreach ($arr as $element) {
            $concatenated[] = $element[$field];
        }
        return $concatenated;
    }

    function startsWith($haystack, $needle)
    {
        return (strpos($haystack, $needle) === 0);
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
        return $valuesOccurrences ? max($valuesOccurrences) : 0;
    }

    function publicGetCurrentPlayerId()
    {
        return self::getCurrentPlayerId();
    }

    /**
     * Each player get 1 point per satisfied guest + 1 point per pair
     */
    function updateScoresWithAlternativeEnd()
    {
        $players = self::loadPlayersBasicInfos();
        $scoresByPlayer = [];
        foreach ($players as $player_id => $player) {
            $woncards = $this->guestcards->getCardsInLocation(DECK_LOC_WON, $player_id);
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
            $scoresByPlayer[$player_id] = $score;
        }
        $tiedPlayers = array_keys($scoresByPlayer, max($scoresByPlayer));
        if (count($tiedPlayers) > 1) {
            //if tie on score, we look at desserts cards number in hand
            $cardsByPlayer = $this->dessertcards->countCardsByLocationArgs(DECK_LOC_HAND);
            //the ones with most cards win
            foreach ($cardsByPlayer as $player => $nb) {
                if (in_array($player, $tiedPlayers)) {
                    $this->updateTieScore($player, $nb);
                }
            }
        }
        $this->reloadScoresAndNotify();
    }

    function goToTie()
    {
        /*
        $reds = [1, 11, 20, 21];
        $purples = [2, 4, 15, 24];
        $blues = [7, 8, 12, 25];
        $greens = [3, 5, 6, 14];
        $oranges = [10, 13, 19, 23];
        $yellows = [16, 17, 18, 22];

        $reds = ["AGENT_17", 'MRS_JENKINS', 'THE_LITTLE_BOY', 'THE_LITTLE_GIRL'];
        $purples = ['BOB_FRUITCAKE', 'CANDICE', 'THE_ASTRONAUT', 'WALLY'];
        $blues = ['MARY_ANN', 'MOJO', 'GRANNY', 'THE_PROFESSOR'];
        $greens = ['BOSTON_GUY', 'FUZZY', 'INGA', 'ROLAND'];
        $oranges = ['MR_HEALTHY', 'NATURE_GIRL', 'THE_HIPPIE', 'THE_TOURIST'];
        $yellows = ['THE_DUDE', 'THE_EMPEROR', 'THE_HERMIT', 'THE_LUMBERJACK'];
        */

        $notWinningSets[] = ["AGENT_17", 'MRS_JENKINS', 'BOB_FRUITCAKE', 'CANDICE', 'BOSTON_GUY', 'FUZZY', 'THE_HIPPIE', 'THE_TOURIST'];
        $notWinningSets[] = ['THE_LITTLE_BOY', 'THE_LITTLE_GIRL', 'THE_ASTRONAUT', 'WALLY', 'GRANNY', 'THE_PROFESSOR', 'THE_HERMIT', 'THE_LUMBERJACK'];
        $notWinningSets[] = ['MR_HEALTHY', 'NATURE_GIRL', 'THE_DUDE', 'THE_EMPEROR', 'INGA', 'ROLAND', 'MARY_ANN']; //missing MOJO

        $cards = $this->guestcards->getCardsOfType("MOJO");
        $this->guestcards->moveCard(array_shift($cards)["id"], DECK_LOC_DISCARD);

        $players = self::loadPlayersBasicInfos();
        $i = 0;
        foreach ($players as $player_id => $player) {
            if ($i < 3) {
                foreach ($notWinningSets[$i] as $completeType) {
                    $type = substr($completeType, 0, 16);
                    $cards = $this->guestcards->getCardsOfType($type);
                    $this->guestcards->moveCard(array_shift($cards)["id"], DECK_LOC_WON, $player_id);
                }
            }
            $i++;
        }
    }

    function updateScores($winner_id)
    {
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player_id => $player) {
            $score = 0;
            if ($player_id == $winner_id) {
                $nbCards = $this->guestcards->countCardInLocation(DECK_LOC_WON, $winner_id);
                $score = 100 + $nbCards;
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

    function updateTieScore($player_id, $score)
    {
        $sql = "UPDATE player set player_score_aux =" . $score . " where player_id=" . $player_id;
        self::DbQuery($sql);
    }

    function reloadScoresAndNotify()
    {
        $playerInfo = self::getCollectionFromDB("SELECT player_id, player_score FROM player");

        // Update the scores on the client side
        self::notifyAllPlayers(NOTIF_UPDATE_SCORE, '', array(
            'players' => $playerInfo
        ));
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
        self::setGameStateValue(GS_LAST_DISCARDED_GUEST_ID, $last_card_id);
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
        return $this->getGuestFromMaterialFromCard($guest);
    }

    private function getGuestFromMaterialFromCard($guest)
    {
        return $this->guests[$guest["type_arg"]];
    }

    private function getDessertFromMaterialFromCard($dessert)
    {
        return $this->desserts[$dessert["type_arg"]];
    }

    private function getGuestsFromMaterialByCards($guests)
    {
        $guestsFromMaterial = array();
        foreach ($guests as $guest) {
            $guestsFromMaterial[] = $this->getGuestFromMaterialFromCard($guest);
        }
        return $guestsFromMaterial;
    }

    private function getDessertsFromMaterialByCards($desserts)
    {
        $fromMaterial = array();
        foreach ($desserts as $guest) {
            $fromMaterial[] = $this->getDessertFromMaterialFromCard($guest);
        }
        return $fromMaterial;
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

    private function getDessertsFromMaterialByIds($desserts_ids)
    {
        $cards = $this->dessertcards->getCards($desserts_ids);
        return $this->getDessertsFromMaterialByCards($cards);
    }

    function isOpeningABuffetOn()
    {
        return self::getGameStateValue('opening_a_buffet') == ACTIVATED;
    }

    function isPoachingOn()
    {
        return self::getGameStateValue('poaching') == ACTIVATED;
    }

    function isExpansionBaconOn()
    {
        return self::getGameStateValue('expansion_bacon') == ACTIVATED;
    }

    function checkGuestAcceptsTheseDesserts($dessertsFromMaterial, $guestFromMaterial)
    {
        if (!self::dessertsAreEnoughForGuest($dessertsFromMaterial, $guestFromMaterial))
            throw new BgaUserException(self::_("This guest is not satisfied with your desserts"));

        if (!self::guestDislikesSomething($dessertsFromMaterial, $guestFromMaterial))
            throw new BgaUserException(self::_("This guest refuses to eat one of the ingredients you provided"));
    }

    function isPoachingAvailable()
    {
        return self::getGameStateValue(GS_ALREADY_POACHED_THIS_TURN) == 0 && $this->guestcards->countCardInLocation(DECK_LOC_WON) > 0;
    }

    function getPlayerName($player_id)
    {
        $sql = "select player_name from player where player_id=" . $player_id;
        return self::getUniqueValueFromDB($sql);
    }

    //////////////////////////////////////////////////////////////////////////////
    //////////// Player actions
    //////////// 

    /*
        Each time a player is doing some game action, one of the methods below is called.
        (note: each method below must match an input method in justdesserts.action.php)
    */
    function draw()
    {
        $player_id = self::getActivePlayerId();

        // Make sure this is an accepted action
        self::checkAction('draw');
        $this->pickDessertCardsAndNotifyPlayer(1, $player_id);

        self::notifyAllPlayers(
            NOTIF_UPDATE_CARDS_NB,
            clienttranslate('${player_name} draws a dessert'),
            array(
                'player_name' => self::getActivePlayerName(),
                'counters' => $this->argNbrCardsInHand(),
            )
        );
        $this->goToDiscardIfNeededOrGoTo(TRANSITION_DRAWN);
    }

    function swap($cards_id)
    {
        self::checkAction('swap');
        $player_id = self::getActivePlayerId();
        $cards_nb = sizeof($cards_id);

        $this->playDessertCards($cards_id);
        $new_cards = $this->dessertcards->pickCards($cards_nb, DECK_LOC_DECK, $player_id);
        // Notify player about his cards
        self::notifyPlayer($player_id, NOTIF_NEW_HAND, '', array('cards' => $new_cards));
        self::incStat(1, "player_swaps_number", $player_id);

        $discardedDesserts = $this->getDessertCardsFromIds($cards_id);
        self::notifyAllPlayers(NOTIF_DISCARDED_DESSERTS, clienttranslate('${player_name} swaps ${cards_nb} cards'), array(
            'player_name' => self::getActivePlayerName(),
            'player_id' => $player_id,
            'cards_nb' => $cards_nb,
            'discardedDesserts' => $discardedDesserts,
        ));

        $this->goToDiscardIfNeededOrGoTo(TRANSITION_SWAPPED);
    }

    function discardGuests($cards_id)
    {
        $cards_nb = sizeof($cards_id);

        self::checkAction('discardGuests');

        $cards = $this->guestcards->getCardsInLocation(DECK_LOC_RIVER);
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
            $valuesOccurrences[$color] += -1;
            if (!array_key_exists($color, $pbOccurrences)) {
                $cardsFromOtherColors = true;
            }
        }
        //there is only one card of each and no extra card is discarded
        if (!$cardsFromOtherColors && max($valuesOccurrences) == 1 && min($valuesOccurrences) >= 0) {
            $this->playGuestCards($cards_id);
            self::notifyAllPlayers(
                NOTIF_DISCARDED_GUESTS,
                clienttranslate('${player_name} discards ${cards_nb} guest(s)'),
                array(
                    'player_name' => self::getActivePlayerName(),
                    'cards_nb' => $cards_nb,
                    'cards' => $guests_to_remove,
                    'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop(DECK_LOC_DISCARD)
                )
            );
            $this->gamestate->nextState(TRANSITION_GUESTS_DISCARDED);
        } else {
            throw new BgaUserException(self::_("Dicard only guests needed to keep one of each suite at most"));
        }
    }

    private function serve($guest_id, $cards_id, $action, $nextState)
    {
        self::checkAction($action);
        $guest = $this->guestcards->getCard($guest_id);
        $guestFromMaterial = $this->getGuestFromMaterialFromCard($guest);
        $dessertsFromMaterial = $this->getDessertsFromMaterialByIds($cards_id);

        $this->checkGuestAcceptsTheseDesserts($dessertsFromMaterial, $guestFromMaterial);
        $this->doSatisfiedGuestActions($cards_id, $guest, $guestFromMaterial, $dessertsFromMaterial);

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
        self::checkAction("pass");
        $this->goToDiscardIfNeededOrGoTo(TRANSITION_PASSED);
    }


    /***************************** Opening a buffet ****************************/
    function openBuffet($cards_id)
    {
        self::checkAction('openBuffet');
        $player_id = self::getActivePlayerId();

        $dessertsFromMaterial = $this->getDessertsFromMaterialByIds($cards_id);
        foreach ($dessertsFromMaterial as $dessert) {
            if (count($dessert["tastes"]) != 1) {
                throw new BgaUserException(self::_("You can use only one ingredient desserts to open a buffet"));
            }
        }

        self::setGameStateValue(GS_OPENING_BUFFET_PLAYER, $player_id);
        $this->playDessertCards($cards_id);
        $new_cards = $this->dessertcards->pickCards(3, DECK_LOC_DECK, $player_id);
        // Notify player about his cards
        self::notifyPlayer($player_id, NOTIF_NEW_HAND, '', array('cards' => $new_cards));
        self::incStat(1, "opened_buffets_number", $player_id);

        //notify everyone about discarded desserts
        $discardedDesserts = $this->getDessertCardsFromIds($cards_id);
        self::notifyAllPlayers(NOTIF_DISCARDED_DESSERTS, clienttranslate('${player_name} opens a buffet and gets 3 desserts'), array(
            'player_name' => self::getActivePlayerName(),
            'player_id' => $player_id,
            'discardedDesserts' => $discardedDesserts,
            'counters' => $this->argNbrCardsInHand(),

        ));

        $other_players = $this->getOtherPlayersHavingWonCards();
        if (count($other_players) > 0) {
            $this->gamestate->nextState(TRANSITION_BUFFET_OPENED);
        } else {
            $this->goToDiscardIfNeededOrGoTo(TRANSITION_BUFFET_SERVE);
        }
    }

    /**
     * A won guest discarded is going on the table.
     */
    function discardWonGuest($guest_id)
    {
        self::checkAction('discardWonGuest');
        $this->guestcards->moveCard($guest_id, DECK_LOC_RIVER);

        $guestName = $this->getGuestFromMaterial($guest_id)["name"];
        self::notifyAllPlayers(NOTIF_NEW_RIVER,  clienttranslate('${player_name} discards ${card_name}'), array(
            'cards' => [$this->guestcards->getCard($guest_id)],
            'from_player_id' => self::getCurrentPlayerId(),
            'player_name' => self::getCurrentPlayerName(),
            'card_name' => $guestName,
        ));

        $this->gamestate->setPlayerNonMultiactive(self::getCurrentPlayerId(), TRANSITION_BUFFET_GUEST_DISCARDED);
    }

    /***************************** Poaching and blocking ****************************/
    function poachGuestFrom($guest_id, $poached_player_id, $desserts_ids)
    {
        self::checkAction('poach');

        $player_id = self::getActivePlayerId();
        $guest = $this->guestcards->getCard($guest_id);
        $guestFromMaterial = $this->getGuestFromMaterial($guest_id);
        $dessertsFromMaterial = $this->getDessertsFromMaterialByIds($desserts_ids);

        if (!$guest || $guest["location"] != DECK_LOC_WON) {
            throw new BgaUserException("This card can not be poached");
        }
        $this->checkGuestAcceptsTheseDesserts($dessertsFromMaterial, $guestFromMaterial);

        self::setGameStateValue(GS_ALREADY_POACHED_THIS_TURN, 1);
        self::setGameStateValue(GS_POACHING_PLAYER, $player_id);
        self::setGameStateValue(GS_POACHED_PLAYER, $poached_player_id);
        self::setGameStateValue(GS_POACHED_GUEST_ID, $guest_id);

        $this->dessertcards->moveCards($desserts_ids, DECK_LOC_BLOCK, $player_id);

        //self::incGameStateValue(GS_GUESTS_SERVED_THIS_TURN);


        //blocking impossible
        if ($this->isGuestGivenHisFavourite($this->getDessertsFromMaterialByIds($desserts_ids), $guestFromMaterial) && !$guestFromMaterial["favourite2"]) {
            $this->doSuccessfullPoachingActions();
            $this->gamestate->nextState(TRANSITION_POACHING_RESOLVED);
        } else {
            $players = self::loadPlayersBasicInfos();
            self::notifyAllPlayers("msg",  clienttranslate('${poaching_player_name} tries to poach ${guest_name} from ${poached_player_name}'), array(
                'poaching_player_name' => self::getActivePlayerName(),
                'poached_player_name' => $players[$poached_player_id]["player_name"],
                'guest_name' => $guestFromMaterial["name"],
                'counters' => $this->argNbrCardsInHand(),
            ));

            $this->gamestate->nextState(TRANSITION_POACHING_ATTEMPT);
        }
    }

    function goToCorrectServeState()
    {
        self::dump("*******************GS_GUESTS_SERVED_THIS_TURN", self::getGameStateValue(GS_GUESTS_SERVED_THIS_TURN));
        if (self::getGameStateValue(GS_GUESTS_SERVED_THIS_TURN) == 0) {
            $this->gamestate->nextState(TRANSITION_PLAYER_TURN);
        } else if (self::getGameStateValue(GS_GUESTS_SERVED_THIS_TURN) == 1) {
            $this->gamestate->nextState(TRANSITION_SERVED);
        } else {
            $this->gamestate->nextState(TRANSITION_SECOND_GUEST_SERVED);
        }
    }

    function doSuccessfullPoachingActions()
    {
        $poaching_player_id = self::getGameStateValue(GS_POACHING_PLAYER);
        $poached_player_id = self::getGameStateValue(GS_POACHED_PLAYER);
        $guest_id = self::getGameStateValue(GS_POACHED_GUEST_ID);

        $this->guestcards->moveCard($guest_id, DECK_LOC_WON, $poaching_player_id);
        self::incGameStateValue(GS_GUESTS_SERVED_THIS_TURN, 1);
        self::incStat(1, "guests_number", $poaching_player_id);
        self::incStat(1, "poaching_number", $poaching_player_id);

        $this->pickDessertCardsAndNotifyPlayer(1, $poached_player_id);

        $dessert_cards = $this->dessertcards->getCardsInLocation(DECK_LOC_BLOCK, $poaching_player_id);
        $dessert_cards_id = $this->concatenateFieldValues($dessert_cards, "id");

        $dessertsFromMaterial = $this->getDessertsFromMaterialByIds($dessert_cards_id);
        $guestFromMaterial = $this->getGuestFromMaterial($guest_id);

        $players = self::loadPlayersBasicInfos();
        self::notifyAllPlayers(NOTIF_GUEST_POACHED,  clienttranslate('${poaching_player_name} poaches ${guest_name} from ${poached_player_name}. ${poached_player_name} gets a dessert.'), array(
            'guest' => $this->guestcards->getCard($guest_id),
            'player_id' => $poaching_player_id,
            'poached_player_id' => $poached_player_id,
            'poaching_player_name' => $players[$poaching_player_id]["player_name"],
            'poached_player_name' => $players[$poached_player_id]["player_name"],
            'guest_name' => $guestFromMaterial["name"],
            'discardedDesserts' => $dessert_cards,
            'counters' => $this->argNbrCardsInHand(),
        ));

        $this->giveTipIfNeeded($dessertsFromMaterial, $guestFromMaterial, $poaching_player_id);
    }

    function blockPoaching($desserts_ids)
    {
        $poaching_player_id = self::getGameStateValue(GS_POACHING_PLAYER);
        $poached_player_id = self::getGameStateValue(GS_POACHED_PLAYER);
        $guest_id = self::getGameStateValue(GS_POACHED_GUEST_ID);

        $dessertsFromMaterial = $this->getDessertsFromMaterialByIds($desserts_ids);
        $guestFromMaterial = $this->getGuestFromMaterial($guest_id);

        $this->checkGuestAcceptsTheseDesserts($dessertsFromMaterial, $guestFromMaterial);

        //use cards
        $this->playDessertCards($desserts_ids);
        self::incStat(1, "blocking_number", $poached_player_id);
        $discardedDesserts = $this->getDessertCardsFromIds($desserts_ids);

        //give back the desserts to the poaching player
        $dessert_cards = $this->dessertcards->getCardsInLocation(DECK_LOC_BLOCK, $poaching_player_id);
        $dessert_cards_id = $this->concatenateFieldValues($dessert_cards, "id");
        $this->dessertcards->moveCards($dessert_cards_id, DECK_LOC_HAND, $poaching_player_id);
        self::notifyPlayer($poaching_player_id, NOTIF_NEW_HAND, '', array('cards' => $dessert_cards, 'fromDiscard' => true));

        self::notifyAllPlayers(NOTIF_POACHING_BLOCKED,  clienttranslate('${poached_player_name} blocks poaching'), array(
            'poached_player_name' => self::getCurrentPlayerName(),
            'player_id' => $poached_player_id,
            'discardedDesserts' => $discardedDesserts,
            'counters' => $this->argNbrCardsInHand(),
        ));

        $this->giveTipIfNeeded($dessertsFromMaterial, $guestFromMaterial, $poached_player_id);

        //$this->goToCorrectServeState();
        $this->gamestate->nextState(TRANSITION_POACHING_BLOCKED);
    }

    function letPoaching()
    {
        $this->doSuccessfullPoachingActions();
        //$this->goToCorrectServeState();
        $this->gamestate->nextState(TRANSITION_SERVED);
    }
    //////////////////////////////////////////////////////////////////////////////
    //////////// Game state arguments
    ////////////

    /*
        Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
        These methods function is to return some additional information that is specific to the current
        game state.
    */
    function argNbrCardsInHand()
    {
        $players = self::getObjectListFromDB("SELECT player_id id FROM player", true);
        $counters = array();
        for ($i = 0; $i < ($this->getPlayersNumber()); $i++) {
            $counters['cards_count_' . $players[$i]] = array('counter_name' => 'cards_count_' . $players[$i], 'counter_value' => 0);
        }
        $cards_in_hand = $this->dessertcards->countCardsByLocationArgs(DECK_LOC_HAND);
        foreach ($cards_in_hand as $player_id => $cards_nbr) {
            $counters['cards_count_' . $player_id]['counter_value'] = $cards_nbr;
        }
        return $counters;
    }

    function argGetPossibleMoves()
    {
        return array(
            "possibleActions" => array(
                "poachAction" =>  $this->isPoachingAvailable(),
            )
        );
    }

    function argGetPoachedGuest()
    {
        return array(
            'poached_guest_id' => self::getGameStateValue(GS_POACHED_GUEST_ID),
            'poached_player_id' => self::getGameStateValue(GS_POACHED_PLAYER)
        );
    }

    //////////////////////////////////////////////////////////////////////////////
    //////////// Game state actions
    ////////////

    /*
        Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
        The action method of state X is called everytime the current game state is set to X.
    */

    /** Draws a dessert and a guest at the beginning of each turn for non zombie players. */
    function stNextPlayer()
    {
        $players = self::loadPlayersBasicInfos();
        $player_id = self::activeNextPlayer();
        self::setGameStateValue(GS_POACHING_PLAYER, 0);
        self::setGameStateValue(GS_POACHED_PLAYER, 0);
        self::setGameStateValue(GS_GUESTS_SERVED_THIS_TURN, 0);
        self::setGameStateValue(GS_ALREADY_POACHED_THIS_TURN, 0);

        if (!self::isZombie($player_id)) {
            self::incStat(1, "turns_number", $player_id);

            $pickedGuests = $this->pickGuestCardsAndNotifyPlayers(1, $players);
            $this->pickDessertCardsAndNotifyPlayer(1, $player_id);

            if ($pickedGuests) {
                $guestName = $this->getGuestFromMaterial($pickedGuests[0]["id"])["name"];
                self::notifyAllPlayers(
                    NOTIF_PLAYER_TURN,
                    clienttranslate('New turn : ${player_name} draws a dessert and ${guestName}'),
                    array(
                        'player_name' => self::getActivePlayerName(),
                        "guestName" => $guestName,
                    )
                );
            } else {
                self::notifyAllPlayers(
                    NOTIF_PLAYER_TURN,
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

    /**
     * Makes the others players active if they have won cards to discard
     */
    function stMakeOtherActive()
    {
        $other_players = $this->getOtherPlayersHavingWonCards();
        $this->gamestate->setPlayersMultiactive($other_players, TRANSITION_BUFFET_GUEST_DISCARDED, true);
    }

    function getOtherPlayersHavingWonCards()
    {
        $player_id = self::getGameStateValue(GS_OPENING_BUFFET_PLAYER);
        $other_players = self::getObjectListFromDB("SELECT distinct card_location_arg id FROM guestcard WHERE card_location_arg !=" . $player_id . " and card_location='" . DECK_LOC_WON . "' group by card_location_arg having count(card_type_arg)>0", true);
        return $other_players;
    }

    function stActivatePoached()
    {
        $poached_player = self::getGameStateValue(GS_POACHED_PLAYER);
        $this->gamestate->setPlayersMultiactive([$poached_player], TRANSITION_BUFFET_GUEST_DISCARDED, true);
    }

    function stPoachingResolved()
    {
        $player = self::getGameStateValue(GS_POACHING_PLAYER);
        $this->checkIfEndOfGame($player);
        $this->goToCorrectServeState();
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
                    $this->dessertcards->pickCardForLocation(DECK_LOC_DECK, DECK_LOC_DISCARD);
                    $this->gamestate->nextState(TRANSITION_DRAWN);
                    break;
                case "serveSecondGuest":
                    $this->gamestate->nextState(TRANSITION_PASSED);
                    break;
                case "playerDiscardGuest":
                    $this->zombieDiscard();
                    $this->gamestate->nextState(TRANSITION_GUESTS_DISCARDED);
                    break;
                case "allPlayersDiscardGuest":
                    $this->gamestate->nextState(TRANSITION_BUFFET_GUEST_DISCARDED);
                    break;
            }
            return;
        } else {
            switch ($statename) {
                case "poachingReaction":
                    $this->letPoaching();
                    break;
            }
            return;
        }
        throw new BgaUserException("Zombie mode not supported at this game state: " . $statename);
    }


    function zombieDiscard()
    {
        if ($this->guestsNeedsToBeDiscarded()) {
            $river_cards = $this->guestcards->getCardsInLocation(DECK_LOC_RIVER);
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
                NOTIF_DISCARDED_GUESTS,
                clienttranslate('The player who left discards ${cards_nb} guest(s)'),
                array(
                    'cards_nb' => count($guests_to_remove),
                    'cards' => $guests_to_remove,
                    'newGuestOnTopOfDiscard' => $this->guestcards->getCardOnTop(DECK_LOC_DISCARD)
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
