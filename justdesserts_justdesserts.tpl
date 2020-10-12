{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- JustDesserts implementation : © <Your name here> <Your email address here>
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
        <div class="whiteblock piles">
            <div id="guest_draw" class="pile draw guest_pile"></div>
            <div id="guest_discard" class="pile discard guest_pile"></div>
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
        <div id="guest_{PLAYER_ID}" class="whiteblock guestsWon">
            <div class="guestsname" style="color:#{PLAYER_COLOR}">
                {PLAYER_NAME}
            </div>
            <div class="guestscard" id="guestscards_{PLAYER_ID}" class="guests">
            </div>
        </div>
        <!-- END player -->

    </div>
</div>

<script type="text/javascript">

    // Javascript HTML templates

    /*
    // Example:
    var jstpl_some_game_item='<div class="my_game_item" id="my_game_item_${MY_ITEM_ID}"></div>';
    
    */

</script>

{OVERALL_GAME_FOOTER}