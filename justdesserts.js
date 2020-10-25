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
                console.log('justdesserts constructor');

                this.cardwidth = 150;
                this.cardheight = 233;

                this.smallCardwidth = 90;
                this.smallCardheight = 140;

                // Here, you can init the global variables of your user interface
                // Example:
                // this.myGlobalValue = 0;
                this.image_items_per_row = 10;
                this.dessert_cards_nb = 76;
                this.guest_cards_nb = 24;
                this.desserts_img = 'img/desserts150.jpg';
                this.small_desserts_img = 'img/desserts90x140.jpg';
                this.guest_img = 'img/guests150x233.jpg';
                this.big_guest_img = 'img/guests250x388.jpg';
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
                console.log(gamedatas);

                // TODO: Set up your game interface here, according to "gamedatas"
                this.isOpeningABuffetOn = gamedatas.isOpeningABuffetOn;

                //---------- Player hand setup
                this.playerHand = new ebg.stock(); // new stock object for hand
                this.playerHand.create(this, $('myhand'), this.cardwidth, this.cardheight);//myhand is the div where the card is going
                this.playerHand.image_items_per_row = this.image_items_per_row;

                // Create cards types:
                for (var card_id = 1; card_id <= this.dessert_cards_nb; card_id++) {
                    // Build card type id
                    this.playerHand.addItemType(card_id, 0, g_gamethemeurl + this.desserts_img, card_id);
                }

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
                for (var card_id = 1; card_id <= this.guest_cards_nb; card_id++) {
                    // Build card type id
                    this.guestsOnTable.addItemType(card_id, 0, g_gamethemeurl + this.guest_img, card_id);
                }

                for (var card_id in gamedatas.guestsOnTable) {
                    var card = gamedatas.guestsOnTable[card_id];
                    //console.log("ajout dans les guests de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.addToStockWithId(card.type_arg, card.id);
                    this.addCardToolTip(this.guestsOnTable, card.id);
                }

                //-----------guest discard setup
                this.guestsDiscard = new ebg.stock();
                this.guestsDiscard.create(this, $('guest_discard'), this.cardwidth, this.cardheight);
                this.guestsDiscard.image_items_per_row = this.image_items_per_row;

                // Create cards types:
                for (var card_id = 1; card_id <= this.guest_cards_nb; card_id++) {
                    // Build card type id
                    this.guestsDiscard.addItemType(card_id, card_id, g_gamethemeurl + this.guest_img, card_id);
                }

                var lastDiscardedGuest = gamedatas.lastDiscardedGuest;
                if (lastDiscardedGuest) {
                    //console.log("ajout dans la defausse de la carte id/type/type arg :" + lastDiscardedGuest.id + " " + lastDiscardedGuest.type + " " + lastDiscardedGuest.type_arg);
                    this.guestsDiscard.addToStockWithId(lastDiscardedGuest.type_arg, lastDiscardedGuest.id);
                    this.addCardToolTip(this.guestsDiscard, lastDiscardedGuest.id);
                    dojo.removeClass("guest_discard", "jd_empty");
                }

                //-----------won cards setup for each player
                this.wonStocksByPlayerId = [];
                for (var player_id in gamedatas.won) {

                    var playerWonCards = new ebg.stock();
                    playerWonCards.setSelectionMode(0);
                    playerWonCards.setOverlap(16, 0);
                    playerWonCards.create(this, $('guestscards_' + player_id), this.cardwidth, this.cardheight);
                    playerWonCards.image_items_per_row = this.image_items_per_row;

                    // Create cards types:
                    for (var card_id = 1; card_id <= this.guest_cards_nb; card_id++) {
                        // Build card type id
                        playerWonCards.addItemType(card_id, 0, g_gamethemeurl + this.guest_img, card_id);
                    }

                    //adds already won cards
                    var cards = gamedatas.won[player_id];
                    for (var card_id in cards) {
                        var card = cards[card_id];
                        //console.log("ajout dans les cartes gagnées de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                        playerWonCards.addToStockWithId(card.type_arg, card.id);
                        this.addCardToolTip(playerWonCards, card.id);
                    }
                    this.wonStocksByPlayerId[player_id] = playerWonCards;
                }

                //cards number
                for (var player_id in gamedatas.players) {
                    var player_board_div = $('player_board_' + player_id);
                    dojo.place(this.format_block('jstpl_cards_icon', {
                        id: player_id,
                    }), player_board_div);
                    var el = 'cards_icon_' + player_id;
                    this.addTooltipHtml(el, _('Number of cards in hand'));
                }
                this.updateCounters(this.gamedatas.counters);

                //discarded desserts list
                this.discardedDesserts = new ebg.stock(); // new stock object for hand
                this.discardedDesserts.create(this, $('desserts_discarded_cards'), this.smallCardwidth, this.smallCardheight);
                this.discardedDesserts.image_items_per_row = this.image_items_per_row;
                this.discardedDesserts.setSelectionMode(0);

                // Create cards types:
                for (var card_id = 1; card_id <= this.dessert_cards_nb; card_id++) {
                    // Build card type id
                    this.discardedDesserts.addItemType(card_id, 0, g_gamethemeurl + this.small_desserts_img, card_id);
                }

                for (var card_id in gamedatas.discardedDesserts) {
                    var card = gamedatas.discardedDesserts[card_id];
                    //console.log("ajout dans la liste de défausse de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.discardedDesserts.addToStockWithId(card.type_arg, card.id);
                }

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
                console.log('Entering state: ' + stateName);
                switch (stateName) {

                    /* Example:
                    
                    case 'myGameState':
                    
                        // Show some HTML block at this game state
                        dojo.style( 'my_html_block_id', 'display', 'block' );
                        
                        break;
                   */
                    case 'playerTurn':
                        this.updateCounters(args.args);
                        this.guestsOnTable.setSelectionMode(1);
                        break;
                    case 'serveSecondGuest':
                        this.updateCounters(args.args);
                        this.guestsOnTable.setSelectionMode(1);
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

                    /* Example:
                    
                    case 'myGameState':
                    
                        // Hide the HTML block we are displaying only during this game state
                        dojo.style( 'my_html_block_id', 'display', 'none' );
                        
                        break;
                   */
                    case 'allPlayersDiscardGuest':
                        this.guestsOnTable.setSelectionMode(1);
                        this.guestsDiscard.setSelectionMode(1);
                        this.wonStocksByPlayerId[this.player_id].setSelectionMode(0);
                        this.playerHand.setSelectionMode(2);
                        break;
                }
            },

            // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
            //                        action status bar (ie: the HTML links in the status bar).
            //        
            onUpdateActionButtons: function (stateName, args) {
                console.log('onUpdateActionButtons: ' + stateName);

                if (this.isCurrentPlayerActive()) {
                    switch (stateName) {
                        case "playerTurn":
                            this.addActionButton('button_serve', _('Serve a guest'), 'onServeGuest');
                            this.addActionButton('button_draw', _('Draw a dessert'), 'onDraw');
                            this.addActionButton('button_exchange', _('Swap desserts'), 'onExchange');
                            if (this.isOpeningABuffetOn) {
                                this.addActionButton('button_openBuffet', _('Open a buffet'), 'onOpenBuffet');
                            }
                            break;
                        case "serveSecondGuest":
                            this.addActionButton('button_serve_second_guest', _('Serve another guest'), 'onServeSecondGuest');
                            this.addActionButton('button_pass', _('Pass'), 'onPass');
                            break;
                        case "playerDiscardGuest":
                            this.addActionButton('button_discard', _('Discard until there is only one guest from each suite'), 'onDiscardGuests');
                            break;
                        case "allPlayersDiscardGuest":
                            this.addActionButton('button_discardWonGuest', _('Give back a satisfied guest'), 'onDiscardWonGuest');
                            break;
                    }
                }

            },

            ///////////////////////////////////////////////////
            //// Utility methods
            addCardToolTip: function (cards, card_id, delay = 200) {
                // Get the div of current card
                curDiv = cards.getItemDivId(card_id);

                // Get the background position information 
                backPos = dojo.style(curDiv, 'backgroundPosition');
                // Add tooltip info
                this.addTooltipHtml(curDiv, this.format_block('jstpl_card_tooltip', {
                    backpos: backPos,
                }), delay);

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
                                items.forEach(removed => {
                                    this.discardedDesserts.addToStockWithId(removed.type, removed.id, "myhand");
                                    this.playerHand.removeFromStockById(removed.id);
                                });
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
                    this.showMessage(_('You have to select one guest and one or several desserts first'), 'error');
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
                }
            },

            onDiscardGuests: function (evt) {
                //console.log('onDiscardGuests');

                // Preventing default browser reaction
                dojo.stopEvent(evt);

                var selectedGuests = this.guestsOnTable.getSelectedItems();
                if (selectedGuests.length > 0) {
                    if (this.checkAction('discardGuests')) {
                        this.ajaxcall('/justdesserts/justdesserts/discardGuestsAction.html',
                            {
                                lock: true,
                                cards_id: selectedGuests.map(i => i.id).join(";"),
                            },
                            this,
                            function (result) { });
                    }
                }
                else {
                    this.showMessage(_('You have to select at least one guest to discard'), 'error');
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

                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    //console.log("notif_newHand card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.playerHand.addToStockWithId(card.type_arg, card.id, 'guest_draw');
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
                    this.addCardToolTip(this.guestsOnTable, card.id);
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
                //the active player display has already been refreshed
                if (this.playerID != notif.args.player_id) {
                    for (var i in notif.args.discardedDesserts) {
                        var card = notif.args.discardedDesserts[i];
                        // console.log("notif_discardedDesserts card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                        this.discardedDesserts.addToStockWithId(card.type_arg, card.id, 'overall_player_board_' + notif.args.player_id);
                    }
                }
            },

            notif_newGuestWon: function (notif) {
                var card = notif.args.card;
                var player_id = notif.args.player_id;
                var from_discard = notif.args.fromDiscard;
                //console.log("notif_newGuestWon card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);

                this.wonStocksByPlayerId[player_id].addToStockWithId(card.type_arg, card.id, from_discard ? 'guest_discard' : 'guests_on_table');
                this.addCardToolTip(this.wonStocksByPlayerId[player_id], card.id);

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
                    this.addCardToolTip(this.guestsDiscard, card.id);
                }
            },

            notif_updateScore: function (notif) {
                // Adjust the score for all the players
                for (var player_id in notif.args.players) {
                    var player = notif.args.players[player_id];
                    var playerID = player['player_id'];

                    this.scoreCtrl[playerID].setValue(player['player_score']);
                }
            },
        });
    });
