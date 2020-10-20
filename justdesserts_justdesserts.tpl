{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- JustDesserts implementation : © Séverine Kamycki severinek@gmail.com
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    justdesserts_justdesserts.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->
<div id="container">
    <div id="guest_line">
        <div class="whiteblock jd_piles">
            <div id="guest_draw" class="jd_pile jd_draw jd_guest_pile"></div>
            <div id="guest_discard" class="jd_pile jd_discard jd_guest_pile jd_empty"></div>
        </div>
        <div id="guests_on_table_wrapper" class="whiteblock">
            <div id="guests_on_table"></div>
        </div>
    </div>

    <div id="myhand_wrap" class="whiteblock">
        <h3>{MY_HAND}</h3>
        <div id="myhand">
        </div>
    </div>

    <div id="guests_wrapper">

        <!-- BEGIN player -->
        <div id="guest_{PLAYER_ID}" class="whiteblock jd_guestsWon">
            <div class="guestsname" style="color:#{PLAYER_COLOR}">
                <h3>{PLAYER_NAME_WON_CARDS_TITLE}</h3>
            </div>
            <div class="guestscard" id="guestscards_{PLAYER_ID}" class="jd_guests">
            </div>
        </div>
        <!-- END player -->

    </div>

    <div id="desserts_discarded_block" class="whiteblock">
        <h3>{DISCARDED_DESSERTS}</h3>
        <div id="desserts_discarded_cards">
        </div>
    </div>
</div>

<script type="text/javascript">

    // Javascript HTML templates

    /*
    // Example:
    var jstpl_some_game_item='<div class="my_game_item" id="my_game_item_${MY_ITEM_ID}"></div>';
    
    */
    var jstpl_cards_icon = '<div id= "cards_panel_${id}"> \
    <div id="cards_icon_${id}" class="jd_cards_icon"></div><span id="cards_count_${id}" class="cards_count"></span></div>';
</script>



{OVERALL_GAME_FOOTER}