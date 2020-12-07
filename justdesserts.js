/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © Séverine Kamycki severinek@gmail.com
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * justdesserts.js
 *
 * JustDesserts user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo", "dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",
    "ebg/stock"
],
    function (dojo, declare) {
        return declare("bgagame.justdesserts", ebg.core.gamegui, {
            constructor: function () {
                //console.log('justdesserts constructor');

                this.cardwidth = 150;
                this.cardheight = 233;

                this.smallCardwidth = 90;
                this.smallCardheight = 140;

                // Here, you can init the global variables of your user interface
                // Example:
                // this.myGlobalValue = 0;
                this.image_items_per_row = 10;
                this.desserts_img = 'img/cards/desserts150x233.jpg';
                this.small_desserts_img = 'img/cards/desserts90x140.jpg';
                this.guest_img = 'img/cards/guests150x233.jpg';
                this.big_guest_img = 'img/cards/guests250x388.jpg';
            },

            /*
                setup:
                
                This method must set up the game user interface according to current game situation specified
                in parameters.
                
                The method is called each time the game interface is displayed to a player, ie:
                _ when the game starts
                _ when a player refreshes the game page (F5)
                
                "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
            */

            setup: function (gamedatas) {
                //console.log("Starting game setup");
                //console.log("gamedatas ", gamedatas);

                // TODO: Set up your game interface here, according to "gamedatas"
                this.isOpeningABuffetOn = gamedatas.isOpeningABuffetOn;
                this.isPoachingOn = gamedatas.isPoachingOn;

                this.cardsAvailable = gamedatas.cardsAvailable;
                this.guestDescriptions = gamedatas.cardsDescription["guests"];

                //---------- Player hand setup
                this.playerHand = new ebg.stock(); // new stock object for hand
                this.playerHand.create(this, $('myhand'), this.cardwidth, this.cardheight);//myhand is the div where the card is going
                this.playerHand.image_items_per_row = this.image_items_per_row;
                this.playerHand.item_margin = 6;
                this.playerHand.apparenceBorderWidth = '2px';

                // Create cards types:
                this.cardsAvailable.desserts.forEach(range => {
                    for (var card_id = range.from; card_id <= range.to; card_id++) {
                        // Build card type id
                        this.playerHand.addItemType(card_id, 0, g_gamethemeurl + this.desserts_img, card_id);
                    }
                });

                for (var card_id in gamedatas.hand) {
                    var card = gamedatas.hand[card_id];
                    //console.log("ajout dans la main de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.playerHand.addToStockWithId(card.type_arg, card.id);
                }


                //-----------guest on table setup
                this.guestsOnTable = new ebg.stock();
                this.guestsOnTable.create(this, $('guests_on_table'), this.cardwidth, this.cardheight);
                this.guestsOnTable.image_items_per_row = this.image_items_per_row;
                this.guestsOnTable.centerItems = true;

                // Create cards types:
                this.cardsAvailable.guests.forEach(range => {
                    for (var card_id = range.from; card_id <= range.to; card_id++) {
                        // Build card type id
                        this.guestsOnTable.addItemType(card_id, 0, g_gamethemeurl + this.guest_img, card_id);
                    }
                });

                for (var card_id in gamedatas.guestsOnTable) {
                    var card = gamedatas.guestsOnTable[card_id];
                    //console.log("ajout dans les guests de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.addToStockWithId(card.type_arg, card.id);
                    this.addCardToolTip(this.guestsOnTable, card.id, card.type_arg);
                }

                //-----------guest discard setup
                this.guestsDiscard = new ebg.stock();
                this.guestsDiscard.create(this, $('guest_discard'), this.cardwidth, this.cardheight);
                this.guestsDiscard.image_items_per_row = this.image_items_per_row;

                // Create cards types:
                this.cardsAvailable.guests.forEach(range => {
                    for (var card_id = range.from; card_id <= range.to; card_id++) {
                        // Build card type id
                        this.guestsDiscard.addItemType(card_id, card_id, g_gamethemeurl + this.guest_img, card_id);
                    }
                });

                var lastDiscardedGuest = gamedatas.lastDiscardedGuest;
                if (lastDiscardedGuest) {
                    //console.log("ajout dans la defausse de la carte id/type/type arg :" + lastDiscardedGuest.id + " " + lastDiscardedGuest.type + " " + lastDiscardedGuest.type_arg);
                    this.guestsDiscard.addToStockWithId(lastDiscardedGuest.type_arg, lastDiscardedGuest.id);
                    this.addCardToolTip(this.guestsDiscard, lastDiscardedGuest.id, lastDiscardedGuest.type_arg);
                    dojo.removeClass("guest_discard", "jd_empty");
                }

                //-----------won cards setup for each player
                this.wonStocksByPlayerId = [];
                for (var player_id in gamedatas.won) {

                    var playerWonCards = new ebg.stock();
                    playerWonCards.setSelectionMode(0);
                    if (!this.isPoachingOn) {
                        playerWonCards.setOverlap(16, 0);

                    } else {
                        var div = 'guest_' + player_id;
                        dojo.style(div, "min-width", "100%");
                    }
                    playerWonCards.create(this, $('guestscards_' + player_id), this.cardwidth, this.cardheight);
                    playerWonCards.image_items_per_row = this.image_items_per_row;

                    // Create cards types:
                    this.cardsAvailable.guests.forEach(range => {
                        for (var card_id = range.from; card_id <= range.to; card_id++) {
                            // Build card type id
                            playerWonCards.addItemType(card_id, 0, g_gamethemeurl + this.guest_img, card_id);
                        }
                    });

                    //adds already won cards
                    var cards = gamedatas.won[player_id];
                    for (var card_id in cards) {
                        var card = cards[card_id];
                        //console.log("ajout dans les cartes gagnées de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                        playerWonCards.addToStockWithId(card.type_arg, card.id);
                        this.addCardToolTip(playerWonCards, card.id, card.type_arg);
                    }
                    this.wonStocksByPlayerId[player_id] = playerWonCards;
                }

                //cards counts
                for (var player_id in gamedatas.players) {
                    var player_board_div = $('player_board_' + player_id);

                    dojo.place(this.format_block('jstpl_won_cards_icons', {
                        id: player_id,
                    }), player_board_div);
                    var el = 'won_cards_icon_' + player_id;
                    this.addTooltipHtml(el, _('Number of won guests of each suit'));

                    var won_cards_div = $('won_cards_panel_' + player_id);
                    for (var colorIndex in gamedatas.usefulColors) {
                        dojo.place(this.format_block('jstpl_won_cards_icon', {
                            id: player_id,
                            color: gamedatas.usefulColors[colorIndex],
                        }), won_cards_div);
                    };

                    dojo.place(this.format_block('jstpl_cards_icon', {
                        id: player_id,
                    }), player_board_div);
                    var el = 'cards_icon_' + player_id;
                    this.addTooltipHtml(el, _('Number of cards in hand'));
                }

                //discarded desserts list
                this.discardedDesserts = new ebg.stock(); // new stock object for hand
                this.discardedDesserts.create(this, $('desserts_discarded_cards'), this.smallCardwidth, this.smallCardheight);
                this.discardedDesserts.image_items_per_row = this.image_items_per_row;
                this.discardedDesserts.setSelectionMode(0);

                // Create cards types:
                this.cardsAvailable.desserts.forEach(range => {
                    for (var card_id = range.from; card_id <= range.to; card_id++) {
                        // Build card type id
                        this.discardedDesserts.addItemType(card_id, 0, g_gamethemeurl + this.small_desserts_img, card_id);
                    }
                });

                for (var card_id in gamedatas.discardedDesserts) {
                    var card = gamedatas.discardedDesserts[card_id];
                    //console.log("ajout dans la liste de défausse de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.discardedDesserts.addToStockWithId(card.type_arg, card.id);
                }

                this.updateCounters(this.gamedatas.counters);

                // Setup game notifications to handle (see "setupNotifications" method below)
                this.setupNotifications();

                console.log("Ending game setup");
            },


            ///////////////////////////////////////////////////
            //// Game & client states

            // onEnteringState: this method is called each time we are entering into a new game state.
            //                  You can use this method to perform some user interface changes at this moment.
            //
            onEnteringState: function (stateName, args) {
                console.log('Entering state: ' + stateName, args);
                switch (stateName) {
                    case 'playerTurn':
                        this.guestsOnTable.setSelectionMode(1);
                        if (args.args.possibleActions["poachAction"]) {
                            this.activateSelectionOnWonCards(true, this.player_id);
                        }
                        break;
                    case 'serveSecondGuest':
                        this.guestsOnTable.setSelectionMode(1);
                        if (args.args.possibleActions["poachAction"]) {
                            this.activateSelectionOnWonCards(true, this.player_id);
                        }
                        break;
                    case 'nextPlayer':
                        this.updateCounters(args.args);
                        break;
                    case 'allPlayersDiscardGuest':
                        this.guestsOnTable.setSelectionMode(0);
                        this.guestsDiscard.setSelectionMode(0);
                        this.playerHand.setSelectionMode(0);
                        this.wonStocksByPlayerId[this.player_id].setSelectionMode(1);
                        this.updateCounters(args.args);
                        break;
                    case 'poachingReaction':
                        this.updateCounters(args.args.counters);
                        var guestId = args.args.poached_guest_id;
                        this.poachedDiv = this.wonStocksByPlayerId[args.args.poached_player_id].getItemDivId(guestId);
                        dojo.addClass(this.poachedDiv, "jd_poached");
                        break;
                    case 'playerDiscardGuest':
                        this.guestsOnTable.setSelectionMode(1);
                        break;
                    default:
                        this.guestsOnTable.setSelectionMode(2);

                }
            },

            // onLeavingState: this method is called each time we are leaving a game state.
            //                 You can use this method to perform some user interface changes at this moment.
            //
            onLeavingState: function (stateName) {
                console.log('Leaving state: ' + stateName);

                switch (stateName) {
                    case 'allPlayersDiscardGuest':
                        this.guestsOnTable.setSelectionMode(1);
                        this.guestsDiscard.setSelectionMode(1);
                        this.wonStocksByPlayerId[this.player_id].setSelectionMode(0);
                        this.playerHand.setSelectionMode(2);
                        break;

                    case "playerTurn":
                    case "serveSecondGuest":
                        this.activateSelectionOnWonCards(false, null);
                        break;
                    case 'poachingReaction':
                        dojo.removeClass(this.poachedDiv, "jd_poached");
                        break;
                }
            },

            // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
            //                        action status bar (ie: the HTML links in the status bar).
            //        
            onUpdateActionButtons: function (stateName, args) {
                console.log('onUpdateActionButtons: ' + stateName, args);

                if (this.isCurrentPlayerActive()) {
                    switch (stateName) {
                        case "playerTurn":
                            this.addActionButton('button_serve', _('Serve a guest'), 'onServeGuest');
                            this.addActionButton('button_draw', _('Draw a dessert'), 'onDraw');
                            this.addActionButton('button_exchange', _('Dump desserts'), 'onExchange');
                            if (this.isOpeningABuffetOn && args.possibleActions["openBuffetAction"]) {
                                this.addActionButton('button_openBuffet', _('Open a buffet'), 'onOpenBuffet');
                            }
                            if (this.isPoachingOn && args.possibleActions["poachAction"]) {
                                this.addActionButton('button_poach', _('Poach a guest'), 'onPoach');
                            }
                            break;
                        case "serveSecondGuest":
                            this.addActionButton('button_serve_second_guest', _('Serve another guest'), 'onServeSecondGuest');
                            this.addActionButton('button_pass', _('Pass'), 'onPass');
                            if (this.isPoachingOn && args.possibleActions["poachAction"]) {
                                this.addActionButton('button_poach', _('Poach a guest'), 'onPoach');
                            }
                            break;
                        case "playerDiscardGuest":
                            this.addActionButton('button_discard', _('Discard'), 'onDiscardGuest');
                            break;
                        case "allPlayersDiscardGuest":
                            this.addActionButton('button_discardWonGuest', _('Give back a satisfied guest'), 'onDiscardWonGuest');
                            break;
                        case "poachingReaction":
                            this.addActionButton('button_block', _('Block poaching'), 'onBlockPoaching');
                            this.addActionButton('button_let_poaching', _('Pass'), 'onLetPoaching');
                            break;
                    }
                }

            },

            ///////////////////////////////////////////////////
            //// Utility methods
            addCardToolTip: function (cards, card_id, card_type_arg, delay = 200) {
                // Get the div of current card
                curDiv = cards.getItemDivId(card_id);

                // Get the background position information 
                backPos = dojo.style(curDiv, 'backgroundPosition');

                //choose template according to favourite number
                var favouriteNumber = 0;
                if (this.guestDescriptions[card_type_arg].favourite1) favouriteNumber++;
                if (this.guestDescriptions[card_type_arg].favourite2) favouriteNumber++;

                // Add tooltip info
                this.addTooltipHtml(curDiv, this.format_block('jstpl_card_tooltip_' + favouriteNumber + "_favorite", {
                    backpos: backPos,
                    guestName: this.guestDescriptions[card_type_arg].name,
                    favourite1: this.guestDescriptions[card_type_arg].favourite1 ? this.guestDescriptions[card_type_arg].favourite1 : _(""),
                    favourite2: this.guestDescriptions[card_type_arg].favourite2 ? this.guestDescriptions[card_type_arg].favourite2 : _(""),
                }), delay);

            },

            activateSelectionOnWonCards: function (activate, exceptForPlayer) {
                for (var playerId in this.wonStocksByPlayerId) {
                    if (playerId != exceptForPlayer) {
                        stock = this.wonStocksByPlayerId[playerId];
                        if (activate) {
                            stock.setSelectionMode(1);
                        } else {
                            stock.setSelectionMode(0);
                        }
                    }
                }
            },
            ///////////////////////////////////////////////////
            //// Player's action

            /*
             
                Here, you are defining methods to handle player's action (ex: results of mouse click on 
                game objects).
                
                Most of the time, these methods:
                _ check the action is possible at this game state.
                _ make a call to the game server
             
            */

            onDraw: function (evt) {
                //console.log('onDraw');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                if (this.checkAction('draw')) {
                    this.ajaxcall('/justdesserts/justdesserts/drawAction.html',
                        { lock: true },
                        this,
                        function (result) {
                            // animate
                        });
                }
            },

            onExchange: function (evt) {
                //console.log('onExchange');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var items = this.playerHand.getSelectedItems();
                if (items.length > 0) {
                    if (this.checkAction('swap')) {
                        this.ajaxcall('/justdesserts/justdesserts/swapAction.html',
                            {
                                lock: true,
                                cards_id: items.map(i => i.id).join(";")
                            },
                            this,
                            function (result) {
                            });
                    }
                }
                else {
                    this.showMessage(_('You have to select desserts first'), 'error');
                }
            },

            onServeGuest: function (evt) {
                //console.log('onServeGuest');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var selectedDesserts = this.playerHand.getSelectedItems();
                var selectedGuestsOnTable = this.guestsOnTable.getSelectedItems();
                var selectedDiscardedGuests = this.guestsDiscard.getSelectedItems();

                var selectedGuests = selectedGuestsOnTable.concat(selectedDiscardedGuests);
                if (selectedDesserts.length > 0 && selectedGuests.length == 1) {
                    if (this.checkAction('serve')) {
                        this.ajaxcall('/justdesserts/justdesserts/serveAction.html',
                            {
                                lock: true,
                                cards_id: selectedDesserts.map(i => i.id).join(";"),
                                guest_id: selectedGuests[0].id
                            },
                            this,
                            function (result) {
                                selectedDesserts.forEach(removed => {
                                    this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                } else {
                    this.showMessage(_('You have to select only one guest and one or several desserts first'), 'error');
                    this.guestsOnTable.unselectAll();
                    this.guestsDiscard.unselectAll();
                }
            },

            onServeSecondGuest: function (evt) {
                //console.log('onServeSecondGuest');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var selectedDesserts = this.playerHand.getSelectedItems();
                var selectedGuestsOnTable = this.guestsOnTable.getSelectedItems();
                var selectedDiscardedGuests = this.guestsDiscard.getSelectedItems();

                var selectedGuests = selectedGuestsOnTable.concat(selectedDiscardedGuests);
                if (selectedDesserts.length > 0 && selectedGuests.length == 1) {
                    if (this.checkAction('serveSecondGuest')) {
                        this.ajaxcall('/justdesserts/justdesserts/serveSecondGuestAction.html',
                            {
                                lock: true,
                                cards_id: selectedDesserts.map(i => i.id).join(";"),
                                guest_id: selectedGuests[0].id
                            },
                            this,
                            function (result) {
                                selectedDesserts.forEach(removed => {
                                    this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                }
                else {
                    this.showMessage(_('You have to select one guest and one or several desserts first'), 'error');
                    this.guestsOnTable.unselectAll();
                    this.guestsDiscard.unselectAll();
                }
            },

            onDiscardGuest: function (evt) {
                //console.log('onDiscardGuest');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var selectedGuests = this.guestsOnTable.getSelectedItems();
                if (selectedGuests.length == 1) {
                    if (this.checkAction('discardGuest')) {
                        this.ajaxcall('/justdesserts/justdesserts/discardGuestAction.html',
                            {
                                lock: true,
                                guest_id: selectedGuests[0].id,
                            },
                            this,
                            function (result) { });
                    }
                }
                else {
                    this.showMessage(_('You have to select one guest to discard'), 'error');
                    this.guestsOnTable.unselectAll();
                }
            },


            onPass: function (evt) {
                //console.log('onPass');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                if (this.checkAction('pass')) {
                    this.ajaxcall('/justdesserts/justdesserts/passAction.html',
                        {
                            lock: true,
                        },
                        this,
                        function (result) { }
                    );
                }

            },

            onOpenBuffet: function (evt) {
                console.log('onOpenBuffet');

                // Preventing default browser reaction
                dojo.stopEvent(evt);
                this.checkAction('openBuffet');

                var selectedDesserts = this.playerHand.getSelectedItems();
                if (selectedDesserts.length == 4) {
                    this.ajaxcall('/justdesserts/justdesserts/openBuffetAction.html',
                        {
                            lock: true,
                            cards_id: selectedDesserts.map(i => i.id).join(";"),
                        },
                        this,
                        function (result) {
                            selectedDesserts.forEach(removed => {
                                this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                this.playerHand.removeFromStockById(removed.id);
                            });
                        }
                    );
                } else {
                    this.showMessage(_('You have to select four aces to open a buffet'), 'error');
                    this.playerHand.unselectAll();
                }
            },

            onDiscardWonGuest: function (evt) {
                console.log('onDiscardWonGuest');

                // Preventing default browser reaction
                dojo.stopEvent(evt);
                this.checkAction('discardWonGuest');

                var selectedGuests = this.wonStocksByPlayerId[this.player_id].getSelectedItems();
                if (selectedGuests.length == 1) {
                    this.ajaxcall('/justdesserts/justdesserts/discardWonGuestAction.html',
                        {
                            lock: true,
                            guest_id: selectedGuests[0].id,
                        },
                        this,
                        function (result) { this.wonStocksByPlayerId[this.player_id].removeFromStockById(selectedGuests[0].id); }
                    );
                } else {
                    this.showMessage(_('You have to select one of your satisfied guests'), 'error');
                }
            },

            onPoach: function (evt) {
                console.log('onPoach');

                // Preventing default browser reaction
                dojo.stopEvent(evt);
                this.checkAction('poach');

                var selectedDesserts = this.playerHand.getSelectedItems();
                var playersWithSelection = Object.entries(this.wonStocksByPlayerId).filter(([playerId, ws]) => ws.getSelectedItems().length > 0).map(item => item[0]);

                if (playersWithSelection.length == 1 && this.wonStocksByPlayerId[playersWithSelection[0]].getSelectedItems().length == 1) {
                    if (selectedDesserts.length > 0) {
                        var selectedGuests = this.wonStocksByPlayerId[playersWithSelection[0]].getSelectedItems();
                        this.ajaxcall('/justdesserts/justdesserts/poachAction.html',
                            {
                                lock: true,
                                poached_player_id: playersWithSelection[0],
                                guest_id: selectedGuests[0].id,
                                desserts_ids: selectedDesserts.map(i => i.id).join(";"),
                            },
                            this,
                            function (result) {
                                selectedDesserts.forEach(removed => {
                                    this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                    this.playerHand.removeFromStockById(removed.id);
                                });
                            }
                        );
                    } else {
                        this.showMessage(_('You have to select desserts to satisfy the guest'), 'error');
                    }
                } else {
                    this.showMessage(_('You have to select one satisfied guest from another player'), 'error');
                }
            },

            onLetPoaching: function (evt) {
                console.log('onLetPoaching');

                // Preventing default browser reaction
                dojo.stopEvent(evt);
                this.checkAction('letPoaching');
                this.ajaxcall('/justdesserts/justdesserts/letPoachingAction.html',
                    {
                        lock: true,
                    },
                    this,
                    function (result) { }
                );

            },

            onBlockPoaching: function (evt) {
                console.log('onBlockPoaching');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var selectedDesserts = this.playerHand.getSelectedItems();
                if (selectedDesserts.length > 0) {
                    if (this.checkAction('blockPoaching')) {
                        this.ajaxcall('/justdesserts/justdesserts/blockPoachingAction.html',
                            {
                                lock: true,
                                desserts_ids: selectedDesserts.map(i => i.id).join(";"),
                            },
                            this,
                            function (result) {
                                selectedDesserts.forEach(removed => {
                                    this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                }
                else {
                    this.showMessage(_('You have to select one or several desserts first'), 'error');
                }
            },

            /* Example:
             
            onMyMethodToCall1: function( evt )
            {
                console.log( 'onMyMethodToCall1' );
                
                // Preventing default browser reaction
                dojo.stopEvent( evt );
             
                // Check that this action is possible (see "possibleactions" in states.inc.php)
                if( ! this.checkAction( 'myAction' ) )
                {   return; }
             
                this.ajaxcall( "/justdesserts/justdesserts/myAction.html", { 
                                                                        lock: true, 
                                                                        myArgument1: arg1, 
                                                                        myArgument2: arg2,
                                                                        ...
                                                                     }, 
                             this, function( result ) {
                                
                                // What to do after the server call if it succeeded
                                // (most of the time: nothing)
                                
                             }, function( is_error) {
             
                                // What to do after the server call in anyway (success or failure)
                                // (most of the time: nothing)
             
                             } );        
            },        
             
            */


            ///////////////////////////////////////////////////
            //// Reaction to cometD notifications

            /*
                setupNotifications:
                
                In this method, you associate each of your game notifications with your local method to handle it.
                
                Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
                      your justdesserts.game.php file.
             
            */
            setupNotifications: function () {
                // TODO: here, associate your game notifications with local methods

                // Example 1: standard notification handling
                // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );

                // Example 2: standard notification handling + tell the user interface to wait
                //            during 3 seconds after calling the method in order to let the players
                //            see what is happening in the game.
                // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
                // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
                // 
                dojo.subscribe('newHand', this, "notif_newHand");
                dojo.subscribe('newRiver', this, "notif_newRiver");
                dojo.subscribe('discardedGuests', this, "notif_discardedGuests");
                dojo.subscribe('newGuestWon', this, "notif_newGuestWon");
                dojo.subscribe('updateScore', this, "notif_updateScore");
                dojo.subscribe('discardedDesserts', this, "notif_discardedDesserts");
                dojo.subscribe('guestPoached', this, "notif_guestPoached");
                dojo.subscribe('poachingBlocked', this, "notif_poachBlocked");
                dojo.subscribe('updateCardsNb', this, "notif_updateCardsNb");
                dojo.subscribe('clearLocation', this, "notif_clearLocation");

            },

            // TODO: from this point and below, you can write your game notifications handling methods

            /*
            Example:
             
            notif_cardPlayed: function( notif )
            {
                console.log( 'notif_cardPlayed' );
                console.log( notif );
                
                // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call
                
                // TODO: play the card in the user interface.
            },    
             
            */
            notif_newHand: function (notif) {

                //if it was a swap, cards must be removed before new ones are added
                if (notif.args.discardedDesserts) {
                    notif.args.discardedDesserts.forEach(removed => {
                        this.playerHand.removeFromStockById(removed.id);
                        //they are added to the discard in the discarded notif because the deck may have been reshuffled, we don’t know for sure at this momment if they go to the discard pile
                    });
                }

                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    console.log("notif_newHand card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);

                    //add new cards
                    var from = 'guest_draw';
                    if (notif.args.fromDiscard) {//given back after a blocked poach
                        from = "desserts_discarded_cards";
                    }
                    this.playerHand.addToStockWithId(card.type_arg, card.id, from);
                    if (notif.args.fromDiscard) {
                        this.discardedDesserts.removeFromStockById(card.id);
                    }

                }
            },

            notif_newRiver: function (notif) {
                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    //console.log("notif_newRiver card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    $from = 'guest_draw';
                    if (notif.args.from_player_id) {
                        $from = "guest_" + notif.args.from_player_id;
                    }
                    this.guestsOnTable.addToStockWithId(card.type_arg, card.id, $from);
                    if (notif.args.from_player_id) {
                        this.wonStocksByPlayerId[notif.args.from_player_id].removeFromStockById(card.id);
                    }
                    this.addCardToolTip(this.guestsOnTable, card.id, card.type_arg);
                }
            },

            notif_discardedGuests: function (notif) {
                var card = notif.args.newGuestOnTopOfDiscard;
                this.newGuestOnTopOfDiscard(card, 'guests_on_table');
                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    //console.log("notif_discardedGuests card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.removeFromStockById(card.id);
                }
            },

            notif_discardedDesserts: function (notif) {
                var from = 'overall_player_board_' + notif.args.player_id;
                for (var i in notif.args.discardedDesserts) {
                    var card = notif.args.discardedDesserts[i];
                    //console.log("notif_discardedDesserts card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.discardedDesserts.addToStockWithId(card.type_arg, card.id, from);
                }
                if (notif.args.counters) {
                    this.updateCounters(notif.args.counters);
                }
            },

            notif_newGuestWon: function (notif) {
                var card = notif.args.card;
                var player_id = notif.args.player_id;
                var from_discard = notif.args.fromDiscard;
                //console.log("notif_newGuestWon card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);

                this.wonStocksByPlayerId[player_id].addToStockWithId(card.type_arg, card.id, from_discard ? 'guest_discard' : 'guests_on_table');
                this.addCardToolTip(this.wonStocksByPlayerId[player_id], card.id, card.type_arg);

                if (from_discard) {
                    this.newGuestOnTopOfDiscard(notif.args.newGuestOnTopOfDiscard, null);
                }
                else {
                    this.guestsOnTable.removeFromStockById(card.id);
                }
                this.notif_discardedDesserts(notif);
            },

            newGuestOnTopOfDiscard: function (card, from) {
                this.guestsDiscard.removeAll();
                dojo.addClass("guest_discard", "jd_empty");
                if (card) {
                    dojo.removeClass("guest_discard", "jd_empty");
                    //console.log("newGuestOnTopOfDiscard card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    if (from) {
                        this.guestsDiscard.addToStockWithId(card.type_arg, card.id, from);
                    }
                    else {
                        this.guestsDiscard.addToStockWithId(card.type_arg, card.id);
                    }
                    this.addCardToolTip(this.guestsDiscard, card.id, card.type_arg);
                }
            },

            notif_updateScore: function (notif) {
                // Adjust the score for all the players
                for (var player_id in notif.args.players) {
                    var player = notif.args.players[player_id];
                    var player_to_update_id = player['player_id'];
                    this.scoreCtrl[player_to_update_id].setValue(player['player_score']);
                }
            },

            notif_guestPoached: function (notif) {
                //console.log("notif_guestPoached : ", notif);
                this.notif_discardedDesserts(notif);
                var card = notif.args.guest;
                $from = "guest_" + notif.args.poached_player_id;

                var guestDiv = this.wonStocksByPlayerId[notif.args.poached_player_id].getItemDivId(card.id);
                this.wonStocksByPlayerId[notif.args.player_id].addToStockWithId(card.type_arg, card.id, guestDiv);
                this.wonStocksByPlayerId[notif.args.poached_player_id].removeFromStockById(card.id);

                this.addCardToolTip(this.wonStocksByPlayerId[notif.args.player_id], card.id, card.type_arg);
            },

            notif_poachBlocked: function (notif) {
                //console.log("notif_poachBlocked : ", notif);
                this.notif_discardedDesserts(notif);
            },

            notif_updateCardsNb: function (notif) {
                //console.log("notif_updateCardsNb : ", notif);
                this.updateCounters(notif.args.counters);
            },

            notif_clearLocation: function (notif) {
                // console.log("notif_clearLocation : ", notif);
                switch (notif.args.location) {
                    case "dessertDiscard":
                        this.discardedDesserts.removeAll();
                        break;
                    default:
                }
            },

        });
    });
