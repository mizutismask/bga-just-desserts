/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © <Your name here> <Your email address here>
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
                // Here, you can init the global variables of your user interface
                // Example:
                // this.myGlobalValue = 0;
                this.image_items_per_row = 10;
                this.dessert_cards_nb = 76;
                this.guest_cards_nb = 24;
                this.desserts_img = 'img/desserts150.jpg';
                this.guest_img = 'img/guests150.jpg';
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
                console.log("Starting game setup");
                console.log(gamedatas);
                // TODO: Set up your game interface here, according to "gamedatas"

                //---------- Player hand setup
                this.playerHand = new ebg.stock(); // new stock object for hand
                this.playerHand.create(this, $('myhand'), this.cardwidth, this.cardheight);//myhand is the div where the card is going
                this.playerHand.image_items_per_row = this.image_items_per_row;

                // Create cards types:
                for (var card_id = 1; card_id <= this.dessert_cards_nb; card_id++) {
                    // Build card type id
                    this.playerHand.addItemType(card_id, card_id, g_gamethemeurl + this.desserts_img, card_id);
                }

                for (var card_id in gamedatas.hand) {
                    var card = gamedatas.hand[card_id];
                    console.log("ajout dans la main de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.playerHand.addToStockWithId(card.type_arg, card.id);
                }


                //-----------guest on table setup
                this.guestsOnTable = new ebg.stock();
                this.guestsOnTable.create(this, $('guests_on_table'), this.cardwidth, this.cardheight);
                this.guestsOnTable.image_items_per_row = this.image_items_per_row;

                // Create cards types:
                for (var card_id = 1; card_id <= this.guest_cards_nb; card_id++) {
                    // Build card type id
                    this.guestsOnTable.addItemType(card_id, card_id, g_gamethemeurl + this.guest_img, card_id);
                }

                for (var card_id in gamedatas.guestsOnTable) {
                    var card = gamedatas.guestsOnTable[card_id];
                    console.log("ajout dans les guests de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.addToStockWithId(card.type_arg, card.id);
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
                    console.log("ajout dans la defausse de la carte id/type/type arg :" + lastDiscardedGuest.id + " " + lastDiscardedGuest.type + " " + lastDiscardedGuest.type_arg);
                    this.guestsDiscard.addToStockWithId(card.type_arg, card.id);
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
                        playerWonCards.addItemType(card_id, card_id, g_gamethemeurl + this.guest_img, card_id);
                    }

                    //adds already won cards
                    var cards = gamedatas.won[player_id];
                    for (var card_id in cards) {
                        var card = cards[card_id];
                        console.log("ajout dans les cartes gagnées de la carte id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                        playerWonCards.addToStockWithId(card.type_arg, card.id);
                    }
                    this.wonStocksByPlayerId[player_id] = playerWonCards;
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


                    case 'dummmy':
                        break;
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


                    case 'dummmy':
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
                        /*               
                                         Example:
                         
                                         case 'myGameState':
                                            
                                            // Add 3 action buttons in the action status bar:
                                            
                                            this.addActionButton( 'button_1_id', _('Button 1 label'), 'onMyMethodToCall1' ); 
                                            this.addActionButton( 'button_2_id', _('Button 2 label'), 'onMyMethodToCall2' ); 
                                            this.addActionButton( 'button_3_id', _('Button 3 label'), 'onMyMethodToCall3' ); 
                                            break;
                        */
                        case "playerTurn":
                            this.addActionButton('button_draw', _('Draw a dessert'), 'onDraw');
                            this.addActionButton('button_exchange', _('Exchange desserts'), 'onExchange');
                            this.addActionButton('button_serve', _('Serve a guest'), 'onServeGuest');
                            break;
                        case "serveSecondGuest":
                            this.addActionButton('button_serve_second_guest', _('Serve another guest'), 'onServeSecondGuest');
                            this.addActionButton('button_pass', _('Pass'), 'onPass');
                            break;
                        case "playerDiscardGuest":
                            this.addActionButton('button_discard', _('Discard until there is only one guest from each suite'), 'onDiscardGuests');
                            break;
                    }
                }
            },

            ///////////////////////////////////////////////////
            //// Utility methods

            /*
            
                Here, you can defines some utility methods that you can use everywhere in your javascript
                script.
            
            */

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
                console.log('onDraw');

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
                console.log('onExchange');

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
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                }
            },

            onServeGuest: function (evt) {
                console.log('onServeGuest');

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
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                }
            },

            onServeSecondGuest: function (evt) {
                console.log('onServeSecondGuest');

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
                                    this.playerHand.removeFromStockById(removed.id);
                                });

                            });
                    }
                }
            },

            onDiscardGuests: function (evt) {
                console.log('onDiscardGuests');

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
            },


            onPass: function (evt) {
                console.log('onPass');

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

            onDessertSelectionChangeFunction: function (evt) {
                var items = this.playerHand.getSelectedItems();
                if (items.length > 0) {
                    console.log('Selected desserts ' + items.map(i => i.id).join());
                }
            },
            onGuestSelectionChangeFunction: function (evt) {
                var items = this.guestsOnTable.getSelectedItems();
                if (items.length > 0) {
                    console.log('Selected guests ' + items.map(i => i.id).join());
                }
            },
            onGuestsDiscardSelectionChangeFunction: function (evt) {
                var items = this.guestsDiscard.getSelectedItems();
                if (items.length > 0) {
                    console.log('Selected discarded guests ' + items.map(i => i.id).join());
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
                console.log('notifications subscriptions setup');

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
                dojo.subscribe('guestsRemoved', this, "notif_guestsRemoved");
                dojo.subscribe('newGuestWon', this, "notif_newGuestWon");
                dojo.subscribe('updateScore', this, "notif_updateScore");
                dojo.subscribe('newGuestOnTopOfDiscard', this, "notif_newGuestOnTopOfDiscard");
                dojo.connect(this.playerHand, 'onChangeSelection', this, "onDessertSelectionChangeFunction");
                dojo.connect(this.guestsOnTable, 'onChangeSelection', this, "onGuestSelectionChangeFunction");
                dojo.connect(this.guestsDiscard, 'onChangeSelection', this, "onGuestsDiscardSelectionChangeFunction");
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
                    console.log("notif_newHand card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.playerHand.addToStockWithId(card.type_arg, card.id);
                }
            },

            notif_newRiver: function (notif) {

                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    console.log("notif_newRiver card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.addToStockWithId(card.type_arg, card.id);
                }
            },

            notif_guestsRemoved: function (notif) {
                for (var i in notif.args.cards) {
                    var card = notif.args.cards[i];
                    console.log("notif_guestsRemoved card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsOnTable.removeFromStockById(card.id);
                }
            },

            notif_newGuestWon: function (notif) {
                var card = notif.args.card;
                var player_id = notif.args.player_id;
                console.log("notif_newGuestWon card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                this.guestsOnTable.removeFromStockById(card.id);
                this.wonStocksByPlayerId[player_id].addToStockWithId(card.type_arg, card.id);
            },

            notif_newGuestOnTopOfDiscard: function (notif) {
                var card = notif.args.card;
                this.guestsDiscard.removeAll();
                if (card) {
                    console.log("notif_newGuestOnTopOfDiscard card id/type/type arg :" + card.id + " " + card.type + " " + card.type_arg);
                    this.guestsDiscard.addToStockWithId(card.type_arg, card.id);
                }
            },

            notif_updateScore: function (notif) {
                // Adjust the score for all the players
                for (var player_id in notif.args.players) {
                    var player = notif.args.players[player_id];
                    var playerID = player['player_id'];

                    this.scoreCtrl[playerID].setValue(player['player_score']);
                }
            }


        });
    });
