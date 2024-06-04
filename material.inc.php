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
 * material.inc.php
 *
 * JustDesserts game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */


/*

Example:

$this->card_types = array(
    1 => array( "card_name" => ...,
                ...
              )
);

*/
if(!defined("BLUE")){
  define("BLUE","blue");
  define("GREEN" , "green");
  define("RED" , "red");
  define("PURPLE" , "purple");
  define("ORANGE" , "orange");
  define("YELLOW" , "yellow");
  define("BURGUNDY", "burgundy");
  define("ROSE" , "rose");
}


$this->colors = [BLUE, GREEN, RED, PURPLE, ORANGE, YELLOW, ROSE, BURGUNDY];

$CHOCOLATE = "chocolate";
$COOOKIE = "cookie";
$NUTS = "nuts";
$PIE = "pie";
$SPICES = "spices";
$ICE_CREAM = "iceCream";
$FRUIT = "fruit";
$CAKE = "cake";
$MARSHMALLOW = "marshmallow";
$PASTRY = "pastry";
$VEGGIES = "veggies";
$PUDDING = "pudding";

$BACON = "BACON";//do NOT change the case here
$COFFEE = "COFFEE";//do NOT change the case here

$this->desserts = array(
  1 => array(
    'nameId' => 'BLACK_FOREST_CAKE',
    'name' => clienttranslate('Black forest cake'),
    'nametr' => $this->_('Black forest cake'),
    'tastes' => array($CHOCOLATE, $FRUIT, $CAKE),
  ),
  2 => array(
    'nameId' => 'BOSTON_CREAM_PIE',
    'name' => clienttranslate('Boston cream pie'),
    'nametr' => $this->_('Boston cream pie'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
  ),
  3 => array(
    'nameId' => 'BREAD_PUDDING',
    'name' => clienttranslate('Bread pudding'),
    'nametr' => $this->_('Bread pudding'),
    'tastes' => array($SPICES, $PUDDING),
  ),
  4 => array(
    'nameId' => 'BUTTER_PECAN_ICE_CREAM',
    'name' => clienttranslate('Butter pecan ice cream'),
    'nametr' => $this->_('Butter pecan ice cream'),
    'tastes' => array($NUTS, $ICE_CREAM),
  ),
  5 => array(
    'nameId' => 'CAKE_DONUT_WITH_SPRINKLES',
    'name' => clienttranslate('Cake donut with sprinkles'),
    'nametr' => $this->_('Cake donut with sprinkles'),
    'tastes' => array($CAKE, $PASTRY),
  ),
  6 => array(
    'nameId' => 'CANDIED_GINGER',
    'name' => clienttranslate('Candied ginger'),
    'nametr' => $this->_('Candied ginger'),
    'tastes' => array($SPICES),
  ),
  7 => array(
    'nameId' => 'CANDIED_YAMS',
    'name' => clienttranslate('Candied yams'),
    'nametr' => $this->_('Candied yams'),
    'tastes' => array($MARSHMALLOW, $VEGGIES),
  ),
  8 => array(
    'nameId' => 'CARAMEL_NUT_TORTE',
    'name' => clienttranslate('Caramel nut torte'),
    'nametr' => $this->_('Caramel nut torte'),
    'tastes' => array($NUTS, $CAKE),
  ),
  9 => array(
    'nameId' => 'CARROT_CAKE',
    'name' => clienttranslate('Carrot cake'),
    'nametr' => $this->_('Carrot cake'),
    'tastes' => array($CAKE, $VEGGIES),
  ),
  10 => array(
    'nameId' => 'CHEESECAKE',
    'name' => clienttranslate('Cheesecake'),
    'nametr' => $this->_('Cheesecake'),
    'tastes' => array($PIE),
  ),
  11 => array(
    'nameId' => 'AMBROSIA_SALAD',
    'name' => clienttranslate('Ambrosia salad'),
    'nametr' => $this->_('Ambrosia salad'),
    'tastes' => array($MARSHMALLOW, $FRUIT),
  ),
  12 => array(
    'nameId' => 'CHERRY_PIE',
    'name' => clienttranslate('Cherry pie'),
    'nametr' => $this->_('Cherry pie'),
    'tastes' => array($FRUIT, $PIE),
  ),
  13 => array(
    'nameId' => 'CHOCOLATE_ANGEL_FOOD_CAKE',
    'name' => clienttranslate('Chocolate angel food cake'),
    'nametr' => $this->_('Chocolate angel food cake'),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  14 => array(
    'nameId' => 'CHOCOLATE_CANDY_BAR',
    'name' => clienttranslate('Chocolate candy bar'),
    'nametr' => $this->_('Chocolate candy bar'),
    'tastes' => array($CHOCOLATE),
  ),
  15 => array(
    'nameId' => 'CHOCOLATE_CHIPS_COOKIES',
    'name' => clienttranslate('Chocolate chips cookies'),
    'nametr' => $this->_('Chocolate chips cookies'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  16 => array(
    'nameId' => 'CHOCOLATE_COVERED_MARSHMALLOWS',
    'name' => clienttranslate('Chocolate covered marshmallows'),
    'nametr' => $this->_('Chocolate covered marshmallows'),
    'tastes' => array($MARSHMALLOW, $CHOCOLATE),
  ),
  17 => array(
    'nameId' => 'CHOCOLATE_CREAM_PIE',
    'name' => clienttranslate('Chocolate cream pie'),
    'nametr' => $this->_('Chocolate cream pie'),
    'tastes' => array($CHOCOLATE, $PIE, $PUDDING),
  ),
  18 => array(
    'nameId' => 'CHOCOLATE_DIPPED_STRAWBERRIES',
    'name' => clienttranslate('Chocolate dipped strawberries'),
    'nametr' => $this->_('Chocolate dipped strawberries'),
    'tastes' => array($CHOCOLATE, $FRUIT),
  ),
  19 => array(
    'nameId' => 'CHOCOLATE_ECLAIR',
    'name' => clienttranslate('Chocolate eclair'),
    'nametr' => $this->_('Chocolate eclair'),
    'tastes' => array($CHOCOLATE, $PUDDING, $PASTRY),
  ),
  20 => array(
    'nameId' => 'CHOCOLATE_FONDUE',
    'name' => clienttranslate('Chocolate fondue'),
    'nametr' => $this->_('Chocolate fondue'),
    'tastes' => array($CHOCOLATE, $FRUIT, $MARSHMALLOW),
  ),
  21 => array(
    'nameId' => 'CHOCOLATE_FROSTED_DONUTS',
    'name' => clienttranslate('Chocolate frosted donut'),
    'nametr' => $this->_('Chocolate frosted donut'),
    'tastes' => array($CHOCOLATE, $PASTRY),
  ),
  22 => array(
    'nameId' => 'APPLE_PIE_A_LA_MODE',
    'name' => clienttranslate('Apple pie à la mode'),
    'nametr' => $this->_('Apple pie à la mode'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
  ),
  23 => array(
    'nameId' => 'CHOCOLATE_MOUSSE',
    'name' => clienttranslate('Chocolate mousse'),
    'nametr' => $this->_('Chocolate mousse'),
    'tastes' => array($CHOCOLATE, $PUDDING),
  ),
  24 => array(
    'nameId' => 'CHOCOLATE_SANDWICH_COOKIES',
    'name' => clienttranslate('Chocolate sandwich cookies'),
    'nametr' => $this->_('Chocolate sandwich cookies'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  25 => array(
    'nameId' => 'CINNAMON_ROLL',
    'name' => clienttranslate('Cinnamon roll'),
    'nametr' => $this->_('Cinnamon roll'),
    'tastes' => array($SPICES, $PASTRY),
  ),
  26 => array(
    'nameId' => 'COCONUT_CUSTARD_PIE',
    'name' => clienttranslate('Coconut custard pie'),
    'nametr' => $this->_('Coconut custard pie'),
    'tastes' => array($NUTS, $PUDDING, $PIE),
  ),
  27 => array(
    'nameId' => 'COCONUT_MACAROONS',
    'name' => clienttranslate('Coconut macaroons'),
    'nametr' => $this->_('Coconut macaroons'),
    'tastes' => array($COOOKIE, $NUTS),
  ),
  28 => array(
    'nameId' => 'COFFEE_CAKE',
    'name' => clienttranslate('Coffee cake'),
    'nametr' => $this->_('Coffee cake'),
    'tastes' => array($CAKE, $SPICES, $NUTS),
  ),
  29 => array(
    'nameId' => 'CREME_BRULEE',
    'name' => clienttranslate('Crème brulée'),
    'nametr' => $this->_('Crème brulée'),
    'tastes' => array($PUDDING),
  ),
  30 => array(
    'nameId' => 'CRISPY_RICE_TREATS',
    'name' => clienttranslate('Crispy rice treats'),
    'nametr' => $this->_('Crispy rice treats'),
    'tastes' => array($MARSHMALLOW, $COOOKIE),
  ),
  31 => array(
    'nameId' => 'PROFITEROLLES',
    'name' => clienttranslate('Profiterolles'),
    'nametr' => $this->_('Profiterolles'),
    'tastes' => array($ICE_CREAM, $PASTRY),
  ),
  32 => array(
    'nameId' => 'DEVILS_FOOD_CUPCAKES',
    'name' => clienttranslate("Devil's food cupcakes"),
    'nametr' => $this->_("Devil's food cupcakes"),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  33 => array(
    'nameId' => 'APPLE_TURNOVER',
    'name' => clienttranslate('Apple turnover'),
    'nametr' => $this->_('Apple turnover'),
    'tastes' => array($PASTRY, $FRUIT),
  ),
  34 => array(
    'nameId' => 'FORTUNE_COOKIES',
    'name' => clienttranslate('Fortune cookies'),
    'nametr' => $this->_('Fortune cookies'),
    'tastes' => array($COOOKIE),
  ),
  35 => array(
    'nameId' => 'FRUITCAKE',
    'name' => clienttranslate('Fruit cake'),
    'nametr' => $this->_('Fruit cake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
  ),
  36 => array(
    'nameId' => 'FRUIT_SALAD',
    'name' => clienttranslate('Fruit salade'),
    'nametr' => $this->_('Fruit salade'),
    'tastes' => array($FRUIT),
  ),
  37 => array(
    'nameId' => 'FUDGE',
    'name' => clienttranslate('Fudge'),
    'nametr' => $this->_('Fudge'),
    'tastes' => array($CHOCOLATE),
  ),
  38 => array(
    'nameId' => 'GINGERBREAD_DUDES',
    'name' => clienttranslate('Gingerbread dudes'),
    'nametr' => $this->_('Gingerbread dudes'),
    'tastes' => array($SPICES, $COOOKIE),
  ),
  39 => array(
    'nameId' => 'GLAZED_DONUT',
    'name' => clienttranslate('Glazed donut'),
    'nametr' => $this->_('Glazed donut'),
    'tastes' => array($PASTRY),
  ),
  40 => array(
    'nameId' => 'HOT_FUDGE_SUNDAE',
    'name' => clienttranslate('Hot fudge sundae'),
    'nametr' => $this->_('Hot fudge sundae'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  41 => array(
    'nameId' => 'ICE_CREAM_CAKE',
    'name' => clienttranslate('Ice cream cake'),
    'nametr' => $this->_('Ice cream cake'),
    'tastes' => array($ICE_CREAM, $CAKE),
  ),
  42 => array(
    'nameId' => 'ICE_CREAM_CONE',
    'name' => clienttranslate('Ice cream cone'),
    'nametr' => $this->_('Ice cream cone'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
  ),
  43 => array(
    'nameId' => 'ICE_CREAM_SANDWICH',
    'name' => clienttranslate('Ice cream sandwich'),
    'nametr' => $this->_('Ice cream sandwich'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
  ),
  44 => array(
    'nameId' => 'BAKED_ALASKA',
    'name' => clienttranslate('Baked Alaska'),
    'nametr' => $this->_('Baked Alaska'),
    'tastes' => array($CHOCOLATE, $CAKE, $FRUIT, $ICE_CREAM),
  ),
  45 => array(
    'nameId' => 'LEMON_COOKIE_SQUARES',
    'name' => clienttranslate('Lemon cookie squares'),
    'nametr' => $this->_('Lemon cookie squares'),
    'tastes' => array($FRUIT, $COOOKIE),
  ),
  46 => array(
    'nameId' => 'MINT_CHOCOLATE_MILK_SHAKE',
    'name' => clienttranslate('Mint chocolate milk shake'),
    'nametr' => $this->_('Mint chocolate milk shake'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  47 => array(
    'nameId' => 'NAPOLEON',
    'name' => clienttranslate('Napoléon'),
    'nametr' => $this->_('Napoléon'),
    'tastes' => array($PASTRY),
  ),
  48 => array(
    'nameId' => 'ZUCCHINI_MUFFIN',
    'name' => clienttranslate('Zucchini muffin'),
    'nametr' => $this->_('Zucchini muffin'),
    'tastes' => array($VEGGIES, $CAKE),
  ),
  49 => array(
    'nameId' => 'OATMEAL_RAISIN_COOKIES',
    'name' => clienttranslate('Oatmeal raisin cookies'),
    'nametr' => $this->_('Oatmeal raisin cookies'),
    'tastes' => array($COOOKIE, $FRUIT),
  ),
  50 => array(
    'nameId' => 'ORANGE_SHERBET',
    'name' => clienttranslate('Orange sherbet'),
    'nametr' => $this->_('Orange sherbet'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  51 => array(
    'nameId' => 'PEACH_COBBLER',
    'name' => clienttranslate('Peach cobbler'),
    'nametr' => $this->_('Peach cobbler'),
    'tastes' => array($PIE, $FRUIT),
  ),
  52 => array(
    'nameId' => 'PEANUT_BRITTLE',
    'name' => clienttranslate('Peanut brittle'),
    'nametr' => $this->_('Peanut brittle'),
    'tastes' => array($NUTS),
  ),
  53 => array(
    'nameId' => 'PEANUT_BUTTER_COOKIES',
    'name' => clienttranslate('Peanut butter cookies'),
    'nametr' => $this->_('Peanut butter cookies'),
    'tastes' => array($NUTS, $COOOKIE),
  ),
  54 => array(
    'nameId' => 'PEANUT_BUTTER_CUPS',
    'name' => clienttranslate('Peanut butter cups'),
    'nametr' => $this->_('Peanut butter cups'),
    'tastes' => array($CHOCOLATE, $NUTS),
  ),
  55 => array(
    'nameId' => 'BAKLAVA',
    'name' => clienttranslate('Baklava'),
    'nametr' => $this->_('Baklava'),
    'tastes' => array($NUTS, $PASTRY),
  ),
  56 => array(
    'nameId' => 'PECAN_PIE',
    'name' => clienttranslate('Pecan pie'),
    'nametr' => $this->_('Pecan pie'),
    'tastes' => array($PIE, $NUTS),
  ),
  57 => array(
    'nameId' => 'PINEAPPLE_UPSIDE_DOWN_CAKE',
    'name' => clienttranslate('Pineapple upside down cake'),
    'nametr' => $this->_('Pineapple upside down cake'),
    'tastes' => array($CAKE, $FRUIT),
  ),
  58 => array(
    'nameId' => 'POUND_CAKE',
    'name' => clienttranslate('Pound cake'),
    'nametr' => $this->_('Pound cake'),
    'tastes' => array($CAKE),
  ),
  59 => array(
    'nameId' => 'PUMPIN_ICE_CREAM',
    'name' => clienttranslate('Pumpkin ice cream'),
    'nametr' => $this->_('Pumpkin ice cream'),
    'tastes' => array($ICE_CREAM, $VEGGIES),
  ),
  60 => array(
    'nameId' => 'ZUCCHINI_NUT_BREAD',
    'name' => clienttranslate('Zucchini nut bread'),
    'nametr' => $this->_('Zucchini nut bread'),
    'tastes' => array($VEGGIES, $NUTS, $CAKE),
  ),
  61 => array(
    'nameId' => 'PUMPKIN_PIE',
    'name' => clienttranslate('Pumkpin pie'),
    'nametr' => $this->_('Pumkpin pie'),
    'tastes' => array($VEGGIES, $PIE),
  ),
  62 => array(
    'nameId' => 'RHUBARB_CRUMBLE',
    'name' => clienttranslate('Rhubarb crumble'),
    'nametr' => $this->_('Rhubarb crumble'),
    'tastes' => array($VEGGIES, $PASTRY),
  ),
  63 => array(
    'nameId' => 'SMORES',
    'name' => clienttranslate("s'mores"),
    'nametr' => $this->_("s'mores"),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
  ),
  64 => array(
    'nameId' => 'SHOO_FLY_PIE',
    'name' => clienttranslate('Shoo fly pie'),
    'nametr' => $this->_('Shoo fly pie'),
    'tastes' => array($PIE),
  ),
  65 => array(
    'nameId' => 'SPICE_CAKE',
    'name' => clienttranslate('Spice cake'),
    'nametr' => $this->_('Spice cake'),
    'tastes' => array($SPICES, $CAKE),
  ),
  66 => array(
    'nameId' => 'BANANA_PUDDING',
    'name' => clienttranslate('Banana pudding'),
    'nametr' => $this->_('Banana pudding'),
    'tastes' => array($FRUIT, $PUDDING, $COOOKIE),
  ),
  67 => array(
    'nameId' => 'STRAWBERRY_ICE_CREAM',
    'name' => clienttranslate('Strawberry ice cream'),
    'nametr' => $this->_('Strawberry ice cream'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  68 => array(
    'nameId' => 'STRAWBERRY_SHORTCAKE',
    'name' => clienttranslate('Strawberry shortcake'),
    'nametr' => $this->_('Strawberry shortcake'),
    'tastes' => array($FRUIT, $CAKE),
  ),
  69 => array(
    'nameId' => 'SUGAR_COOKIES',
    'name' => clienttranslate('Sugar cookies'),
    'nametr' => $this->_('Sugar cookies'),
    'tastes' => array($COOOKIE),
  ),
  70 => array(
    'nameId' => 'TAPIOCA_PUDDING',
    'name' => clienttranslate('Tapioca pudding'),
    'nametr' => $this->_('Tapioca pudding'),
    'tastes' => array($PUDDING),
  ),
  71 => array(
    'nameId' => 'TOASTED_MARSHMALLOWS',
    'name' => clienttranslate('Toasted marshmallows'),
    'nametr' => $this->_('Toasted marshmallows'),
    'tastes' => array($MARSHMALLOW),
  ),
  72 => array(
    'nameId' => 'VANILLA_ICE_CREAM',
    'name' => clienttranslate('Vanilla ice cream'),
    'nametr' => $this->_('Vanilla ice cream'),
    'tastes' => array($ICE_CREAM),
  ),
  73 => array(
    'nameId' => 'WALNUT_BROWNIES',
    'name' => clienttranslate('Walnut brownies'),
    'nametr' => $this->_('Walnut brownies'),
    'tastes' => array($CHOCOLATE, $NUTS, $COOOKIE),
  ),
  74 => array(
    'nameId' => 'YELLOW_CAKE',
    'name' => clienttranslate('Yellow cake'),
    'nametr' => $this->_('Yellow cake'),
    'tastes' => array($CAKE),
  ),
  75 => array(
    'nameId' => 'BANANA_SPLIT',
    'name' => clienttranslate('Banana split'),
    'nametr' => $this->_('Banana split'),
    'tastes' => array($CHOCOLATE, $FRUIT, $ICE_CREAM),
  ),
  76 => array(
    'nameId' => 'BELGIAN_WAFFLE',
    'name' => clienttranslate('Belgian waffles'),
    'nametr' => $this->_('Belgian waffles'),
    'tastes' => array($FRUIT, $PASTRY),
  ),

  /*******************Bacon expansion******************/
  77 => array(
    'nameId' => 'CANDIED_BACON',
    'name' => clienttranslate('Candied bacon'),
    'nametr' => $this->_('Candied bacon'),
    'tastes' => array($BACON),
  ),
  78 => array(
    'nameId' => 'MAPLE_BACON_DONUT',
    'name' => clienttranslate('Maple bacon donut'),
    'nametr' => $this->_('Maple bacon donut'),
    'tastes' => array($BACON, $PASTRY),
  ),
  79 => array(
    'nameId' => 'BACON_CHIP_COOKIES',
    'name' => clienttranslate('Bacon chip cookies'),
    'nametr' => $this->_('Bacon chip cookies'),
    'tastes' => array($CHOCOLATE, $BACON, $COOOKIE),
  ),
  80 => array(
    'nameId' => 'BACON_ICE_CREAM',
    'name' => clienttranslate('Bacon ice cream'),
    'nametr' => $this->_('Bacon ice cream'),
    'tastes' => array($BACON, $ICE_CREAM),
  ),
  81 => array(
    'nameId' => 'CHOCOLATE_DIPPED_BACON',
    'name' => clienttranslate('Chocolate dipped bacon'),
    'nametr' => $this->_('Chocolate dipped bacon'),
    'tastes' => array($CHOCOLATE, $BACON),
  ),
  82 => array(
    'nameId' => 'CHOCOLATE_BACON_CUPCAKES',
    'name' => clienttranslate('Chocolate bacon cupcakes'),
    'nametr' => $this->_('Chocolate bacon cupcakes'),
    'tastes' => array($CHOCOLATE, $BACON, $CAKE),
  ),

   /*******************Coffee expansion******************/
   83 => array(
    'nameId' => 'CUP_OF_COFFEE',
    'name' => clienttranslate('Cup of coffee'),
    'nametr' => $this->_('Cup of coffee'),
    'tastes' => array($COFFEE),
  ),
  84 => array(
    'nameId' => 'TIRAMISU',
    'name' => clienttranslate('Tiramisu'),
    'nametr' => $this->_('Tiramisu'),
    'tastes' => array($COFFEE, $CAKE, $CHOCOLATE),
  ),
  85 => array(
    'nameId' => 'COFFEE_WITH_A_DONUT',
    'name' => clienttranslate('Coffee with a donut'),
    'nametr' => $this->_('Coffee with a donut'),
    'tastes' => array($COFFEE, $PASTRY),
  ),
  86 => array(
    'nameId' => 'MOKA_CHEESECAKE',
    'name' => clienttranslate('Moka cheesecake'),
    'nametr' => $this->_('Moka cheesecake'),
    'tastes' => array($COFFEE, $PIE, $CHOCOLATE),
  ),
  87 => array(
    'nameId' => 'COFFEE_ICE_CREAM',
    'name' => clienttranslate('Coffee ice cream'),
    'nametr' => $this->_('Coffee ice cream'),
    'tastes' => array($COFFEE, $ICE_CREAM),
  ),
  88 => array(
    'nameId' => 'CHOCOLATE_ESPRESSO_BEANS',
    'name' => clienttranslate('Chocolate espresso beans'),
    'nametr' => $this->_('Chocolate espresso beans'),
    'tastes' => array($CHOCOLATE, $COFFEE),
  ),
);

$this->guests = array(
  1 => array(
    'nameId' => 'AGENT_17',
    'name' => clienttranslate('Agent 17'),
    'nametr' => $this->_('Agent 17'),
    'tastes' => array($PASTRY, $FRUIT),
    'dislike1' => $NUTS,
    'color' => RED,
    'favourite1' => "APPLE_TURNOVER",
    'favourite2' => "BELGIAN_WAFFLE",
  ),
  2 => array(
    'nameId' => 'BOB_FRUITCAKE',
    'name' => clienttranslate('Bob Fruitcake'),
    'nametr' => $this->_('Bob Fruitcake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => PURPLE,
    'favourite1' => "FRUITCAKE",
    'favourite2' => null,
  ),
  3 => array(
    'nameId' => 'BOSTON_GUY',
    'name' => clienttranslate('Boston Guy'),
    'nametr' => $this->_('Boston Guy'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
    'dislike1' => null,
    'color' => GREEN,
    'favourite1' => "BOSTON_CREAM_PIE",
    'favourite2' => null,
  ),
  4 => array(
    'nameId' => 'CANDICE',
    'name' => 'Candice',
    'nametr' => 'Candice',
    'tastes' => array($MARSHMALLOW, $VEGGIES),
    'dislike1' => $CHOCOLATE,
    'color' => PURPLE,
    'favourite1' => "CANDIED_YAMS",
    'favourite2' => null,
  ),
  5 => array(
    'nameId' => 'FUZZY',
    'name' => 'Fuzzy',
    'nametr' => 'Fuzzy',
    'tastes' => array($CHOCOLATE, $NUTS),
    'dislike1' => $MARSHMALLOW,
    'color' => GREEN,
    'favourite1' => "PEANUT_BUTTER_CUPS",
    'favourite2' => null,
  ),
  6 => array(
    'nameId' => 'INGA',
    'name' => 'Inga',
    'nametr' => 'Inga',
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
    'dislike1' => null,
    'color' => GREEN,
    'favourite1' => "ICE_CREAM_SANDWICH",
    'favourite2' => null,
  ),
  7 => array(
    'nameId' => 'MARY_ANN',
    'name' => clienttranslate('Mary Ann'),
    'nametr' => $this->_('Mary Ann'),
    'tastes' => array($PIE, $PUDDING, $NUTS),
    'dislike1' => null,
    'color' => BLUE,
    'favourite1' => "COCONUT_CUSTARD_PIE",
    'favourite2' => null,
  ),
  8 => array(
    'nameId' => 'MOJO',
    'name' => 'Mojo',
    'nametr' => 'Mojo',
    'tastes' => array($FRUIT, $CAKE, $ICE_CREAM, $CHOCOLATE),
    'dislike1' => null,
    'color' => BLUE,
    'favourite1' => "BAKED_ALASKA",
    'favourite2' => null,
  ),
  9 => array(
    'nameId' => 'MR_HEALTHY',
    'name' => clienttranslate('Mr Healthy'),
    'nametr' => $this->_('Mr Healthy'),
    'tastes' => array($VEGGIES, $PIE),
    'dislike1' => $CHOCOLATE,
    'color' => ORANGE,
    'favourite1' => "PUMPKIN_PIE",
    'favourite2' => null,
  ),
  10 => array(
    'nameId' => 'MRS_JENKINS',
    'name' => clienttranslate('Mrs Jenkins'),
    'nametr' => $this->_('Mrs Jenkins'),
    'tastes' => array($VEGGIES, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => RED,
    'favourite1' => "ZUCCHINI_NUT_BREAD",
    'favourite2' => null,
  ),
  11 => array(
    'nameId' => 'GRANNY',
    'name' => clienttranslate('Granny'),
    'nametr' => $this->_('Granny'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
    'dislike1' => null,
    'color' => BLUE,
    'favourite1' => "APPLE_PIE_A_LA_MODE",
    'favourite2' => null,
  ),
  12 => array(
    'nameId' => 'NATURE_GIRL',
    'name' => clienttranslate('Nature girl'),
    'nametr' => $this->_('Nature girl'),
    'tastes' => array($FRUIT, $SPICES, $VEGGIES),
    'dislike1' => null,
    'color' => ORANGE,
    'favourite1' => null,
    'favourite2' => null,
  ),
  13 => array(
    'nameId' => 'ROLAND',
    'name' => 'Roland',
    'nametr' => 'Roland',
    'tastes' => array($SPICES, $PASTRY),
    'dislike1' => $FRUIT,
    'color' => GREEN,
    'favourite1' => "CINNAMON_ROLL",
    'favourite2' => null,
  ),
  14 => array(
    'nameId' => 'THE_ASTRONAUT',
    'name' => clienttranslate('the astronaut'),
    'nametr' => $this->_('the astronaut'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
    'dislike1' => $NUTS,
    'color' => PURPLE,
    'favourite1' => "CHOCOLATE_CHIPS_COOKIES",
    'favourite2' => "CHOCOLATE_SANDWICH_COOKIES",
  ),
  15 => array(
    'nameId' => 'THE_DUDE',
    'name' => clienttranslate('the dude'),
    'nametr' => $this->_('the dude'),
    'tastes' => array($FRUIT, $CHOCOLATE, $MARSHMALLOW),
    'dislike1' => null,
    'color' => YELLOW,
    'favourite1' => "CHOCOLATE_FONDUE",
    'favourite2' => null,
  ),
  16 => array(
    'nameId' => 'THE_EMPEROR',
    'name' => clienttranslate('the emperor'),
    'nametr' => $this->_('the emperor'),
    'tastes' => array($CAKE, $CHOCOLATE),
    'dislike1' => $FRUIT,
    'dislike2' => $VEGGIES,
    'color' => YELLOW,
    'favourite1' => "DEVILS_FOOD_CUPCAKES",
    'favourite2' => "CHOCOLATE_ANGEL_FOOD_CAKE",
  ),
  17 => array(
    'nameId' => 'THE_HERMIT',
    'name' => clienttranslate('the Hermit'),
    'nametr' => $this->_('the Hermit'),
    'tastes' => array($CHOCOLATE, $PASTRY, $PUDDING),
    'dislike1' => null,
    'color' => YELLOW,
    'favourite1' => "CHOCOLATE_ECLAIR",
    'favourite2' => null,
  ),
  18 => array(
    'nameId' => 'THE_HIPPIE',
    'name' => clienttranslate('the hippie'),
    'nametr' => $this->_('the hippie'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $FRUIT),
    'dislike1' => null,
    'color' => ORANGE,
    'favourite1' => "BANANA_SPLIT",
    'favourite2' => null,
  ),
  19 => array(
    'nameId' => 'THE_LITTLE_BOY',
    'name' => clienttranslate('the little boy'),
    'nametr' => $this->_('the little boy'),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
    'dislike1' => null,
    'color' => RED,
    'favourite1' => "SMORES",
    'favourite2' => null,
  ),
  20 => array(
    'nameId' => 'THE_LITTLE_GIRL',
    'name' => clienttranslate('the little girl'),
    'nametr' => $this->_('the little girl'),
    'tastes' => array($ICE_CREAM, $CAKE),
    'dislike1' => $VEGGIES,
    'color' => RED,
    'favourite1' => "ICE_CREAM_CAKE",
    'favourite2' => null,
  ),
  21 => array(
    'nameId' => 'THE_LUMBERJACK',
    'name' => clienttranslate('the lumberjack'),
    'nametr' => $this->_('the lumberjack'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
    'dislike1' => $NUTS,
    'color' => YELLOW,
    'favourite1' => "ICE_CREAM_CONE",
    'favourite2' => null,
  ),
  22 => array(
    'nameId' => 'THE_TOURIST',
    'name' => clienttranslate('the tourist'),
    'nametr' => $this->_('the tourist'),
    'tastes' => array($FRUIT, $CAKE, $CHOCOLATE),
    'dislike1' => null,
    'color' => ORANGE,
    'favourite1' => "BLACK_FOREST_CAKE",
    'favourite2' => null,
  ),
  23 => array(
    'nameId' => 'WALLY',
    'name' => 'Wally',
    'nametr' => 'Wally',
    'tastes' => array($COOOKIE, $CHOCOLATE, $NUTS),
    'dislike1' => null,
    'color' => PURPLE,
    'favourite1' => "WALNUT_BROWNIES",
    'favourite2' => null,
  ),
  24 => array(
    'nameId' => 'THE_PROFESSOR',
    'name' => clienttranslate('the professor'),
    'nametr' => $this->_('the professor'),
    'tastes' => array($FRUIT, $CAKE),
    'dislike1' => $CHOCOLATE,
    'color' => BLUE,
    'favourite1' => "STRAWBERRY_SHORTCAKE",
    'favourite2' => "PINEAPPLE_UPSIDE_DOWN_CAKE",
  ),

  /*******************Bacon expansion******************/
  25 => array(
    'nameId' => 'KEVIN',
    'name' => clienttranslate('Kevin'),
    'nametr' => $this->_('Kevin'),
    'tastes' => array($CHOCOLATE, $BACON, $CAKE),
    'dislike1' => null,
    'color' => BURGUNDY,
    'favourite1' => "CHOCOLATE_BACON_CUPCAKES",
    'favourite2' => null,
  ),
  26 => array(
    'nameId' => 'ABRAHAM_BACON',
    'name' => clienttranslate('Abraham Bacon'),
    'nametr' => $this->_('Abraham Bacon'),
    'tastes' => array($BACON),
    'dislike1' => null,
    'color' => BURGUNDY,
    'favourite1' => "ANYTHING_WITH_BACON",
    'favourite2' => null,
  ),
  27 => array(
    'nameId' => 'THE_FARMER',
    'name' => clienttranslate('the farmer'),
    'nametr' => $this->_('the farmer'),
    'tastes' => array($COOOKIE, $CHOCOLATE, $BACON),
    'dislike1' => null,
    'color' => BURGUNDY,
    'favourite1' => "BACON_CHIP_COOKIES",
    'favourite2' => null,
  ),
  28 => array(
    'nameId' => 'THE_VEGETARIAN',
    'name' => clienttranslate('the vegetarian'),
    'nametr' => $this->_('the vegetarian'),
    'tastes' => array($FRUIT, $CHOCOLATE),
    'dislike1' => $BACON,
    'dislike2' => $MARSHMALLOW,
    'color' => BURGUNDY,
    'favourite1' => "CHOCOLATE_DIPPED_STRAWBERRIES",
    'favourite2' => null,
  ),

  /*******************Coffee expansion******************/
  29 => array(
    'nameId' => 'DOCTOR_COFFEE',
    'name' => clienttranslate('Doctor Coffee'),
    'nametr' => $this->_('Doctor Coffee'),
    'tastes' => array($COFFEE),
    'dislike1' => null,
    'color' => ROSE,
    'favourite1' => "ANYTHING_WITH_COFFEE",
    'favourite2' => null,
  ),
  30 => array(
    'nameId' => 'THE_MOVIE_STAR',
    'name' => clienttranslate('the movie star'),
    'nametr' => $this->_('the movie star'),
    'tastes' => array($COFFEE, $CAKE, $CHOCOLATE),
    'dislike1' => null,
    'color' => ROSE,
    'favourite1' => "TIRAMISU",
    'favourite2' => null,
  ),
  31 => array(
    'nameId' => 'CONCEPTUAL_ARTIST',
    'name' => clienttranslate('the conceptual artist'),
    'nametr' => $this->_('the conceptual artist'),
    'tastes' => array($CAKE, $SPICES, $NUTS),
    'dislike1' => null,
    'color' => ROSE,
    'favourite1' => "COFFEE_CAKE",
    'favourite2' => null,
  ),
  32 => array(
    'nameId' => 'MS_JITTERS',
    'name' => clienttranslate('Mr. Jitters'),
    'nametr' => $this->_('Mr. Jitters'),
    'tastes' => array($COFFEE, $CHOCOLATE),
    'dislike1' => $FRUIT,
    'color' => ROSE,
    'favourite1' => "CHOCOLATE_ESPRESSO_BEANS",
    'favourite2' => null,
  ),
);
