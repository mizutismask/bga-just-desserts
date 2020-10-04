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

                this.cardwidth = 180;
                this.cardheight = 280;
                // Here, you can init the global variables of your user interface
                // Example:
                // this.myGlobalValue = 0;

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

                // Setting up player boards
                for (var player_id in gamedatas.players) {
                    var player = gamedatas.players[player_id];

                    // TODO: Setting up players boards if needed
                }

                // TODO: Set up your game interface here, according to "gamedatas"
                // Player hand
                this.playerHand = new ebg.stock(); // new stock object for hand
                this.playerHand.create(this, $('myhand'), this.cardwidth, this.cardheight);//myhand is the div where the card is going
                this.playerHand.image_items_per_row = 10; // 10 images per row

                // Create cards types:
                for (var card_id = 1; card_id <= 6; card_id++) {
                    // Build card type id
                    //var card_type_id = this.getCardUniqueId(color, value);
                    this.playerHand.addItemType(card_id, card_id, g_gamethemeurl + 'img/desserts180.jpg', card_id);
                }
                console.log(gamedatas);
                for (var card_id in gamedatas.hand) {
                    var card = gamedatas.hand[card_id];
                    console.log("ajout de la carte :" + card.type);
                    this.playerHand.addToStockWithId(card.type, card.type);
                    // TODO: Setting up players boards if needed
                }
                //this.playerHand.addToStockWithId(6);
                //guest on table setup
                this.guestsOnTable = new ebg.stock(); // new stock object for hand
                this.guestsOnTable.create(this, $('guests_on_table'), this.cardwidth, this.cardheight);
                this.guestsOnTable.image_items_per_row = 10; // 10 images per row

                // Create cards types:
                for (var card_id = 1; card_id <= 3; card_id++) {
                    // Build card type id
                    //var card_type_id = this.getCardUniqueId(color, value);
                    this.guestsOnTable.addItemType(card_id, card_id, g_gamethemeurl + 'img/guests180.jpg', card_id);
                }
                console.log(gamedatas);
                for (var card_id in gamedatas.guestsOnTable) {
                    var card = gamedatas.guestsOnTable[card_id];
                    console.log("ajout de la carte :" + card.type);
                    this.guestsOnTable.addToStockWithId(card.type, card.type);
                    // TODO: Setting up players boards if needed
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
                    }
                }
            },

            ///////////////////////////////////////////////////
            //// Utility methods

            /*
            
                Here, you can defines some utility methods that you can use everywhere in your javascript
                script.
            
            */
            playCardOnTable: function (player_id, color, value, card_id) {
                // player_id => direction
                dojo.place(this.format_block('jstpl_cardontable', null), $('guests_on_table'));
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
                console.log("notif_newHand");
                // We received a new full hand of 13 cards.
                this.playerHand.removeAll();

                for (var i in notif.args.cards) {
                    console.log(notif.args.cards);
                    var card = notif.args.cards[i];
                    console.log("card.id1", card.id);
                    this.playerHand.addToStockWithId(card.id);
                }
            },

            notif_newRiver: function (notif) {
                console.log("notif_newRiver");
                this.guestsOnTable.removeAll();

                for (var i in notif.args.cards) {
                    console.log(notif.args.cards);
                    var card = notif.args.cards[i];
                    console.log("card.id1", card.id);
                    this.guestsOnTable.addToStockWithId(card.id);
                }
            },

        });
    });
