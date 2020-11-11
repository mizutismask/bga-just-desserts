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
$BLUE = "blue";
$GREEN = "green";
$RED = "red";
$PURPLE = "purple";
$ORANGE = "orange";
$YELLOW = "yellow";
$BURGUNDY = "burgundy";
$ROSE = "rose";

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
    'nametr' => self::_('Black forest cake'),
    'tastes' => array($CHOCOLATE, $FRUIT, $CAKE),
  ),
  2 => array(
    'nameId' => 'BOSTON_CREAM_PIE',
    'name' => clienttranslate('Boston cream pie'),
    'nametr' => self::_('Boston cream pie'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
  ),
  3 => array(
    'nameId' => 'BREAD_PUDDING',
    'name' => clienttranslate('Bread pudding'),
    'nametr' => self::_('Bread pudding'),
    'tastes' => array($SPICES, $PUDDING),
  ),
  4 => array(
    'nameId' => 'BUTTER_PECAN_ICE_CREAM',
    'name' => clienttranslate('Butter pecan ice cream'),
    'nametr' => self::_('Butter pecan ice cream'),
    'tastes' => array($NUTS, $ICE_CREAM),
  ),
  5 => array(
    'nameId' => 'CAKE_DONUT_WITH_SPRINKLES',
    'name' => clienttranslate('Cake donut with sprinkles'),
    'nametr' => self::_('Cake donut with sprinkles'),
    'tastes' => array($CAKE, $PASTRY),
  ),
  6 => array(
    'nameId' => 'CANDIED_GINGER',
    'name' => clienttranslate('Candied ginger'),
    'nametr' => self::_('Candied ginger'),
    'tastes' => array($SPICES),
  ),
  7 => array(
    'nameId' => 'CANDIED_YAMS',
    'name' => clienttranslate('Candied yams'),
    'nametr' => self::_('Candied yams'),
    'tastes' => array($MARSHMALLOW, $VEGGIES),
  ),
  8 => array(
    'nameId' => 'CARAMEL_NUT_TORTE',
    'name' => clienttranslate('Caramel nut torte'),
    'nametr' => self::_('Caramel nut torte'),
    'tastes' => array($NUTS, $CAKE),
  ),
  9 => array(
    'nameId' => 'CARROT_CAKE',
    'name' => clienttranslate('Carrot cake'),
    'nametr' => self::_('Carrot cake'),
    'tastes' => array($CAKE, $VEGGIES),
  ),
  10 => array(
    'nameId' => 'CHEESECAKE',
    'name' => clienttranslate('Cheesecake'),
    'nametr' => self::_('Cheesecake'),
    'tastes' => array($PIE),
  ),
  11 => array(
    'nameId' => 'AMBROSIA_SALAD',
    'name' => clienttranslate('Ambrosia salad'),
    'nametr' => self::_('Ambrosia salad'),
    'tastes' => array($MARSHMALLOW, $FRUIT),
  ),
  12 => array(
    'nameId' => 'CHERRY_PIE',
    'name' => clienttranslate('Cherry pie'),
    'nametr' => self::_('Cherry pie'),
    'tastes' => array($FRUIT, $PIE),
  ),
  13 => array(
    'nameId' => 'CHOCOLATE_ANGEL_FOOD_CAKE',
    'name' => clienttranslate('Chocolate angel food cake'),
    'nametr' => self::_('Chocolate angel food cake'),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  14 => array(
    'nameId' => 'CHOCOLATE_CANDY_BAR',
    'name' => clienttranslate('Chocolate candy bar'),
    'nametr' => self::_('Chocolate candy bar'),
    'tastes' => array($CHOCOLATE),
  ),
  15 => array(
    'nameId' => 'CHOCOLATE_CHIPS_COOKIES',
    'name' => clienttranslate('Chocolate chips cookies'),
    'nametr' => self::_('Chocolate chips cookies'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  16 => array(
    'nameId' => 'CHOCOLATE_COVERED_MARSHMALLOWS',
    'name' => clienttranslate('Chocolate covered marshmallows'),
    'nametr' => self::_('Chocolate covered marshmallows'),
    'tastes' => array($MARSHMALLOW, $CHOCOLATE),
  ),
  17 => array(
    'nameId' => 'CHOCOLATE_CREAM_PIE',
    'name' => clienttranslate('Chocolate cream pie'),
    'nametr' => self::_('Chocolate cream pie'),
    'tastes' => array($CHOCOLATE, $PIE, $PUDDING),
  ),
  18 => array(
    'nameId' => 'CHOCOLATE_DIPPED_STRAWBERRIES',
    'name' => clienttranslate('Chocolate dipped strawberries'),
    'nametr' => self::_('Chocolate dipped strawberries'),
    'tastes' => array($CHOCOLATE, $FRUIT),
  ),
  19 => array(
    'nameId' => 'CHOCOLATE_ECLAIR',
    'name' => clienttranslate('Chocolate eclair'),
    'nametr' => self::_('Chocolate eclair'),
    'tastes' => array($CHOCOLATE, $PUDDING, $PASTRY),
  ),
  20 => array(
    'nameId' => 'CHOCOLATE_FONDUE',
    'name' => clienttranslate('Chocolate fondue'),
    'nametr' => self::_('Chocolate fondue'),
    'tastes' => array($CHOCOLATE, $FRUIT, $MARSHMALLOW),
  ),
  21 => array(
    'nameId' => 'CHOCOLATE_FROSTED_DONUTS',
    'name' => clienttranslate('Chocolate frosted donut'),
    'nametr' => self::_('Chocolate frosted donut'),
    'tastes' => array($CHOCOLATE, $PASTRY),
  ),
  22 => array(
    'nameId' => 'APPLE_PIE_A_LA_MODE',
    'name' => clienttranslate('Apple pie à la mode'),
    'nametr' => self::_('Apple pie à la mode'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
  ),
  23 => array(
    'nameId' => 'CHOCOLATE_MOUSSE',
    'name' => clienttranslate('Chocolate mousse'),
    'nametr' => self::_('Chocolate mousse'),
    'tastes' => array($CHOCOLATE, $PUDDING),
  ),
  24 => array(
    'nameId' => 'CHOCOLATE_SANDWICH_COOKIES',
    'name' => clienttranslate('Chocolate sandwich cookies'),
    'nametr' => self::_('Chocolate sandwich cookies'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  25 => array(
    'nameId' => 'CINNAMON_ROLL',
    'name' => clienttranslate('Cinnamon roll'),
    'nametr' => self::_('Cinnamon roll'),
    'tastes' => array($SPICES, $PASTRY),
  ),
  26 => array(
    'nameId' => 'COCONUT_CUSTARD_PIE',
    'name' => clienttranslate('Coconut custard pie'),
    'nametr' => self::_('Coconut custard pie'),
    'tastes' => array($NUTS, $PUDDING, $PIE),
  ),
  27 => array(
    'nameId' => 'COCONUT_MACAROONS',
    'name' => clienttranslate('Coconut macaroons'),
    'nametr' => self::_('Coconut macaroons'),
    'tastes' => array($COOOKIE, $NUTS),
  ),
  28 => array(
    'nameId' => 'COFFEE_CAKE',
    'name' => clienttranslate('Coffee cake'),
    'nametr' => self::_('Coffee cake'),
    'tastes' => array($CAKE, $SPICES, $NUTS),
  ),
  29 => array(
    'nameId' => 'CREME_BRULEE',
    'name' => clienttranslate('Crème brulée'),
    'nametr' => self::_('Crème brulée'),
    'tastes' => array($PUDDING),
  ),
  30 => array(
    'nameId' => 'CRISPY_RICE_TREATS',
    'name' => clienttranslate('Crispy rice treats'),
    'nametr' => self::_('Crispy rice treats'),
    'tastes' => array($MARSHMALLOW, $COOOKIE),
  ),
  31 => array(
    'nameId' => 'PROFITEROLLES',
    'name' => clienttranslate('Profiterolles'),
    'nametr' => self::_('Profiterolles'),
    'tastes' => array($ICE_CREAM, $PASTRY),
  ),
  32 => array(
    'nameId' => 'DEVILS_FOOD_CUPCAKES',
    'name' => clienttranslate("Devil's food cupcakes"),
    'nametr' => self::_("Devil's food cupcakes"),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  33 => array(
    'nameId' => 'APPLE_TURNOVER',
    'name' => clienttranslate('Apple turnover'),
    'nametr' => self::_('Apple turnover'),
    'tastes' => array($PASTRY, $FRUIT),
  ),
  34 => array(
    'nameId' => 'FORTUNE_COOKIES',
    'name' => clienttranslate('Fortune cookies'),
    'nametr' => self::_('Fortune cookies'),
    'tastes' => array($COOOKIE),
  ),
  35 => array(
    'nameId' => 'FRUITCAKE',
    'name' => clienttranslate('Fruit cake'),
    'nametr' => self::_('Fruit cake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
  ),
  36 => array(
    'nameId' => 'FRUIT_SALAD',
    'name' => clienttranslate('Fruit salade'),
    'nametr' => self::_('Fruit salade'),
    'tastes' => array($FRUIT),
  ),
  37 => array(
    'nameId' => 'FUDGE',
    'name' => clienttranslate('Fudge'),
    'nametr' => self::_('Fudge'),
    'tastes' => array($CHOCOLATE),
  ),
  38 => array(
    'nameId' => 'GINGERBREAD_DUDES',
    'name' => clienttranslate('Gingerbread dudes'),
    'nametr' => self::_('Gingerbread dudes'),
    'tastes' => array($SPICES, $COOOKIE),
  ),
  39 => array(
    'nameId' => 'GLAZED_DONUT',
    'name' => clienttranslate('Glazed donut'),
    'nametr' => self::_('Glazed donut'),
    'tastes' => array($PASTRY),
  ),
  40 => array(
    'nameId' => 'HOT_FUDGE_SUNDAE',
    'name' => clienttranslate('Hot fudge sundae'),
    'nametr' => self::_('Hot fudge sundae'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  41 => array(
    'nameId' => 'ICE_CREAM_CAKE',
    'name' => clienttranslate('Ice cream cake'),
    'nametr' => self::_('Ice cream cake'),
    'tastes' => array($ICE_CREAM, $CAKE),
  ),
  42 => array(
    'nameId' => 'ICE_CREAM_CONE',
    'name' => clienttranslate('Ice cream cone'),
    'nametr' => self::_('Ice cream cone'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
  ),
  43 => array(
    'nameId' => 'ICE_CREAM_SANDWICH',
    'name' => clienttranslate('Ice cream sandwich'),
    'nametr' => self::_('Ice cream sandwich'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
  ),
  44 => array(
    'nameId' => 'BAKED_ALASKA',
    'name' => clienttranslate('Baked Alaska'),
    'nametr' => self::_('Baked Alaska'),
    'tastes' => array($CHOCOLATE, $CAKE, $FRUIT, $ICE_CREAM),
  ),
  45 => array(
    'nameId' => 'LEMON_COOKIE_SQUARES',
    'name' => clienttranslate('Lemon cookie squares'),
    'nametr' => self::_('Lemon cookie squares'),
    'tastes' => array($FRUIT, $COOOKIE),
  ),
  46 => array(
    'nameId' => 'MINT_CHOCOLATE_MILK_SHAKE',
    'name' => clienttranslate('Mint chocolate milk shake'),
    'nametr' => self::_('Mint chocolate milk shake'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  47 => array(
    'nameId' => 'NAPOLEON',
    'name' => clienttranslate('Napoléon'),
    'nametr' => self::_('Napoléon'),
    'tastes' => array($PASTRY),
  ),
  48 => array(
    'nameId' => 'ZUCCHINI_MUFFIN',
    'name' => clienttranslate('Zucchini muffin'),
    'nametr' => self::_('Zucchini muffin'),
    'tastes' => array($VEGGIES, $CAKE),
  ),
  49 => array(
    'nameId' => 'OATMEAL_RAISIN_COOKIES',
    'name' => clienttranslate('Oatmeal raisin cookies'),
    'nametr' => self::_('Oatmeal raisin cookies'),
    'tastes' => array($COOOKIE, $FRUIT),
  ),
  50 => array(
    'nameId' => 'ORANGE_SHERBET',
    'name' => clienttranslate('Orange sherbet'),
    'nametr' => self::_('Orange sherbet'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  51 => array(
    'nameId' => 'PEACH_COBBLER',
    'name' => clienttranslate('Peach cobbler'),
    'nametr' => self::_('Peach cobbler'),
    'tastes' => array($PIE, $FRUIT),
  ),
  52 => array(
    'nameId' => 'PEANUT_BRITTLE',
    'name' => clienttranslate('Peanut brittle'),
    'nametr' => self::_('Peanut brittle'),
    'tastes' => array($NUTS),
  ),
  53 => array(
    'nameId' => 'PEANUT_BUTTER_COOKIES',
    'name' => clienttranslate('Peanut butter cookies'),
    'nametr' => self::_('Peanut butter cookies'),
    'tastes' => array($NUTS, $COOOKIE),
  ),
  54 => array(
    'nameId' => 'PEANUT_BUTTER_CUPS',
    'name' => clienttranslate('Peanut butter cups'),
    'nametr' => self::_('Peanut butter cups'),
    'tastes' => array($CHOCOLATE, $NUTS),
  ),
  55 => array(
    'nameId' => 'BAKLAVA',
    'name' => clienttranslate('Baklava'),
    'nametr' => self::_('Baklava'),
    'tastes' => array($NUTS, $PASTRY),
  ),
  56 => array(
    'nameId' => 'PECAN_PIE',
    'name' => clienttranslate('Pecan pie'),
    'nametr' => self::_('Pecan pie'),
    'tastes' => array($PIE, $NUTS),
  ),
  57 => array(
    'nameId' => 'PINEAPPLE_UPSIDE_DOWN_CAKE',
    'name' => clienttranslate('Pineapple upside down cake'),
    'nametr' => self::_('Pineapple upside down cake'),
    'tastes' => array($CAKE, $FRUIT),
  ),
  58 => array(
    'nameId' => 'POUND_CAKE',
    'name' => clienttranslate('Pound cake'),
    'nametr' => self::_('Pound cake'),
    'tastes' => array($CAKE),
  ),
  59 => array(
    'nameId' => 'PUMPIN_ICE_CREAM',
    'name' => clienttranslate('Pumpkin ice cream'),
    'nametr' => self::_('Pumpkin ice cream'),
    'tastes' => array($ICE_CREAM, $VEGGIES),
  ),
  60 => array(
    'nameId' => 'ZUCCHINI_NUT_BREAD',
    'name' => clienttranslate('Zucchini nut bread'),
    'nametr' => self::_('Zucchini nut bread'),
    'tastes' => array($VEGGIES, $NUTS, $CAKE),
  ),
  61 => array(
    'nameId' => 'PUMPKIN_PIE',
    'name' => clienttranslate('Pumkpin pie'),
    'nametr' => self::_('Pumkpin pie'),
    'tastes' => array($VEGGIES, $PIE),
  ),
  62 => array(
    'nameId' => 'RHUBARB_CRUMBLE',
    'name' => clienttranslate('Rhubarb crumble'),
    'nametr' => self::_('Rhubarb crumble'),
    'tastes' => array($VEGGIES, $PASTRY),
  ),
  63 => array(
    'nameId' => 'SMORES',
    'name' => clienttranslate("s'mores"),
    'nametr' => self::_("s'mores"),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
  ),
  64 => array(
    'nameId' => 'SHOO_FLY_PIE',
    'name' => clienttranslate('Shoo fly pie'),
    'nametr' => self::_('Shoo fly pie'),
    'tastes' => array($PIE),
  ),
  65 => array(
    'nameId' => 'SPICE_CAKE',
    'name' => clienttranslate('Spice cake'),
    'nametr' => self::_('Spice cake'),
    'tastes' => array($SPICES, $CAKE),
  ),
  66 => array(
    'nameId' => 'BANANA_PUDDING',
    'name' => clienttranslate('Banana pudding'),
    'nametr' => self::_('Banana pudding'),
    'tastes' => array($FRUIT, $PUDDING, $COOOKIE),
  ),
  67 => array(
    'nameId' => 'STRAWBERRY_ICE_CREAM',
    'name' => clienttranslate('Strawberry ice cream'),
    'nametr' => self::_('Strawberry ice cream'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  68 => array(
    'nameId' => 'STRAWBERRY_SHORTCAKE',
    'name' => clienttranslate('Strawberry shortcake'),
    'nametr' => self::_('Strawberry shortcake'),
    'tastes' => array($FRUIT, $CAKE),
  ),
  69 => array(
    'nameId' => 'SUGAR_COOKIES',
    'name' => clienttranslate('Sugar cookies'),
    'nametr' => self::_('Sugar cookies'),
    'tastes' => array($COOOKIE),
  ),
  70 => array(
    'nameId' => 'TAPIOCA_PUDDING',
    'name' => clienttranslate('Tapioca pudding'),
    'nametr' => self::_('Tapioca pudding'),
    'tastes' => array($PUDDING),
  ),
  71 => array(
    'nameId' => 'TOASTED_MARSHMALLOWS',
    'name' => clienttranslate('Toasted marshmallows'),
    'nametr' => self::_('Toasted marshmallows'),
    'tastes' => array($MARSHMALLOW),
  ),
  72 => array(
    'nameId' => 'VANILLA_ICE_CREAM',
    'name' => clienttranslate('Vanilla ice cream'),
    'nametr' => self::_('Vanilla ice cream'),
    'tastes' => array($ICE_CREAM),
  ),
  73 => array(
    'nameId' => 'WALNUT_BROWNIES',
    'name' => clienttranslate('Walnut brownies'),
    'nametr' => self::_('Walnut brownies'),
    'tastes' => array($CHOCOLATE, $NUTS, $COOOKIE),
  ),
  74 => array(
    'nameId' => 'YELLOW_CAKE',
    'name' => clienttranslate('Yellow cake'),
    'nametr' => self::_('Yellow cake'),
    'tastes' => array($CAKE),
  ),
  75 => array(
    'nameId' => 'BANANA_SPLIT',
    'name' => clienttranslate('Banana split'),
    'nametr' => self::_('Banana split'),
    'tastes' => array($CHOCOLATE, $FRUIT, $ICE_CREAM),
  ),
  76 => array(
    'nameId' => 'BELGIAN_WAFFLE',
    'name' => clienttranslate('Belgian waffles'),
    'nametr' => self::_('Belgian waffles'),
    'tastes' => array($FRUIT, $PASTRY),
  ),

  /*******************Bacon expansion******************/
  77 => array(
    'nameId' => 'CANDIED_BACON',
    'name' => clienttranslate('Candied bacon'),
    'nametr' => self::_('Candied bacon'),
    'tastes' => array($BACON),
  ),
  78 => array(
    'nameId' => 'MAPLE_BACON_DONUT',
    'name' => clienttranslate('Maple bacon donut'),
    'nametr' => self::_('Maple bacon donut'),
    'tastes' => array($BACON, $PASTRY),
  ),
  79 => array(
    'nameId' => 'BACON_CHIP_COOKIES',
    'name' => clienttranslate('Bacon chip cookies'),
    'nametr' => self::_('Bacon chip cookies'),
    'tastes' => array($CHOCOLATE, $BACON, $COOOKIE),
  ),
  80 => array(
    'nameId' => 'BACON_ICE_CREAM',
    'name' => clienttranslate('Bacon ice cream'),
    'nametr' => self::_('Bacon ice cream'),
    'tastes' => array($BACON, $ICE_CREAM),
  ),
  81 => array(
    'nameId' => 'CHOCOLATE_DIPPED_BACON',
    'name' => clienttranslate('Chocolate dipped bacon'),
    'nametr' => self::_('Chocolate dipped bacon'),
    'tastes' => array($CHOCOLATE, $BACON),
  ),
  82 => array(
    'nameId' => 'CHOCOLATE_BACON_CUPCAKES',
    'name' => clienttranslate('Chocolate bacon cupcakes'),
    'nametr' => self::_('Chocolate bacon cupcakes'),
    'tastes' => array($CHOCOLATE, $BACON, $CAKE),
  ),

   /*******************Coffee expansion******************/
   83 => array(
    'nameId' => 'CUP_OF_COFFEE',
    'name' => clienttranslate('Cup of coffee'),
    'nametr' => self::_('Cup of coffee'),
    'tastes' => array($COFFEE),
  ),
  84 => array(
    'nameId' => 'TIRAMISU',
    'name' => clienttranslate('Tiramisu'),
    'nametr' => self::_('Tiramisu'),
    'tastes' => array($COFFEE, $CAKE, $CHOCOLATE),
  ),
  85 => array(
    'nameId' => 'COFFEE_WITH_A_DONUT',
    'name' => clienttranslate('Coffee with a donut'),
    'nametr' => self::_('Coffee with a donut'),
    'tastes' => array($COFFEE, $PASTRY),
  ),
  86 => array(
    'nameId' => 'MOKA_CHEESECAKE',
    'name' => clienttranslate('Moka cheesecake'),
    'nametr' => self::_('Moka cheesecake'),
    'tastes' => array($COFFEE, $PIE, $CHOCOLATE),
  ),
  87 => array(
    'nameId' => 'COFFEE_ICE_CREAM',
    'name' => clienttranslate('Coffee ice cream'),
    'nametr' => self::_('Coffee ice cream'),
    'tastes' => array($COFFEE, $ICE_CREAM),
  ),
  88 => array(
    'nameId' => 'CHOCOLATE_ESPRESSO_BEANS',
    'name' => clienttranslate('Chocolate espresso beans'),
    'nametr' => self::_('Chocolate espresso beans'),
    'tastes' => array($CHOCOLATE, $COFFEE),
  ),
);

$this->guests = array(
  1 => array(
    'nameId' => 'AGENT_17',
    'name' => clienttranslate('Agent 17'),
    'nametr' => self::_('Agent 17'),
    'tastes' => array($PASTRY, $FRUIT),
    'dislike1' => $NUTS,
    'color' => $RED,
    'favourite1' => "APPLE_TURNOVER",
    'favourite2' => "BELGIAN_WAFFLE",
  ),
  2 => array(
    'nameId' => 'BOB_FRUITCAKE',
    'name' => clienttranslate('Bob Fruitcake'),
    'nametr' => self::_('Bob Fruitcake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "FRUITCAKE",
    'favourite2' => null,
  ),
  3 => array(
    'nameId' => 'BOSTON_GUY',
    'name' => clienttranslate('Boston Guy'),
    'nametr' => self::_('Boston Guy'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
    'dislike1' => null,
    'color' => $GREEN,
    'favourite1' => "BOSTON_CREAM_PIE",
    'favourite2' => null,
  ),
  4 => array(
    'nameId' => 'CANDICE',
    'name' => 'Candice',
    'nametr' => 'Candice',
    'tastes' => array($MARSHMALLOW, $VEGGIES),
    'dislike1' => $CHOCOLATE,
    'color' => $PURPLE,
    'favourite1' => "CANDIED_YAMS",
    'favourite2' => null,
  ),
  5 => array(
    'nameId' => 'FUZZY',
    'name' => 'Fuzzy',
    'nametr' => 'Fuzzy',
    'tastes' => array($CHOCOLATE, $NUTS),
    'dislike1' => $MARSHMALLOW,
    'color' => $GREEN,
    'favourite1' => "PEANUT_BUTTER_CUPS",
    'favourite2' => null,
  ),
  6 => array(
    'nameId' => 'INGA',
    'name' => 'Inga',
    'nametr' => 'Inga',
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
    'dislike1' => null,
    'color' => $GREEN,
    'favourite1' => "ICE_CREAM_SANDWICH",
    'favourite2' => null,
  ),
  7 => array(
    'nameId' => 'MARY_ANN',
    'name' => clienttranslate('Mary Ann'),
    'nametr' => self::_('Mary Ann'),
    'tastes' => array($PIE, $PUDDING, $NUTS),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "COCONUT_CUSTARD_PIE",
    'favourite2' => null,
  ),
  8 => array(
    'nameId' => 'MOJO',
    'name' => 'Mojo',
    'nametr' => 'Mojo',
    'tastes' => array($FRUIT, $CAKE, $ICE_CREAM, $CHOCOLATE),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "BAKED_ALASKA",
    'favourite2' => null,
  ),
  9 => array(
    'nameId' => 'MR_HEALTHY',
    'name' => clienttranslate('Mr Healthy'),
    'nametr' => self::_('Mr Healthy'),
    'tastes' => array($VEGGIES, $PIE),
    'dislike1' => $CHOCOLATE,
    'color' => $ORANGE,
    'favourite1' => "PUMPKIN_PIE",
    'favourite2' => null,
  ),
  10 => array(
    'nameId' => 'MRS_JENKINS',
    'name' => clienttranslate('Mrs Jenkins'),
    'nametr' => self::_('Mrs Jenkins'),
    'tastes' => array($VEGGIES, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => $RED,
    'favourite1' => "ZUCCHINI_NUT_BREAD",
    'favourite2' => null,
  ),
  11 => array(
    'nameId' => 'GRANNY',
    'name' => clienttranslate('Granny'),
    'nametr' => self::_('Granny'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "APPLE_PIE_A_LA_MODE",
    'favourite2' => null,
  ),
  12 => array(
    'nameId' => 'NATURE_GIRL',
    'name' => clienttranslate('Nature girl'),
    'nametr' => self::_('Nature girl'),
    'tastes' => array($FRUIT, $SPICES, $VEGGIES),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => null,
    'favourite2' => null,
  ),
  13 => array(
    'nameId' => 'ROLAND',
    'name' => 'Roland',
    'nametr' => 'Roland',
    'tastes' => array($SPICES, $PASTRY),
    'dislike1' => $FRUIT,
    'color' => $GREEN,
    'favourite1' => "CINNAMON_ROLL",
    'favourite2' => null,
  ),
  14 => array(
    'nameId' => 'THE_ASTRONAUT',
    'name' => clienttranslate('the astronaut'),
    'nametr' => self::_('the astronaut'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "CHOCOLATE_CHIPS_COOKIES",
    'favourite2' => "CHOCOLATE_SANDWICH_COOKIES",
  ),
  15 => array(
    'nameId' => 'THE_DUDE',
    'name' => clienttranslate('the dude'),
    'nametr' => self::_('the dude'),
    'tastes' => array($FRUIT, $CHOCOLATE, $MARSHMALLOW),
    'dislike1' => null,
    'color' => $YELLOW,
    'favourite1' => "CHOCOLATE_FONDUE",
    'favourite2' => null,
  ),
  16 => array(
    'nameId' => 'THE_EMPEROR',
    'name' => clienttranslate('the emperor'),
    'nametr' => self::_('the emperor'),
    'tastes' => array($CAKE, $CHOCOLATE),
    'dislike1' => $FRUIT,
    'dislike2' => $VEGGIES,
    'color' => $YELLOW,
    'favourite1' => "DEVILS_FOOD_CUPCAKES",
    'favourite2' => "CHOCOLATE_ANGEL_FOOD_CAKE",
  ),
  17 => array(
    'nameId' => 'THE_HERMIT',
    'name' => clienttranslate('the Hermit'),
    'nametr' => self::_('the Hermit'),
    'tastes' => array($CHOCOLATE, $PASTRY, $PUDDING),
    'dislike1' => null,
    'color' => $YELLOW,
    'favourite1' => "CHOCOLATE_ECLAIR",
    'favourite2' => null,
  ),
  18 => array(
    'nameId' => 'THE_HIPPIE',
    'name' => clienttranslate('the hippie'),
    'nametr' => self::_('the hippie'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $FRUIT),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => "BANANA_SPLIT",
    'favourite2' => null,
  ),
  19 => array(
    'nameId' => 'THE_LITTLE_BOY',
    'name' => clienttranslate('the little boy'),
    'nametr' => self::_('the little boy'),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
    'dislike1' => null,
    'color' => $RED,
    'favourite1' => "SMORES",
    'favourite2' => null,
  ),
  20 => array(
    'nameId' => 'THE_LITTLE_GIRL',
    'name' => clienttranslate('the little girl'),
    'nametr' => self::_('the little girl'),
    'tastes' => array($ICE_CREAM, $CAKE),
    'dislike1' => $VEGGIES,
    'color' => $RED,
    'favourite1' => "ICE_CREAM_CAKE",
    'favourite2' => null,
  ),
  21 => array(
    'nameId' => 'THE_LUMBERJACK',
    'name' => clienttranslate('the lumberjack'),
    'nametr' => self::_('the lumberjack'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
    'dislike1' => $NUTS,
    'color' => $YELLOW,
    'favourite1' => "ICE_CREAM_CONE",
    'favourite2' => null,
  ),
  22 => array(
    'nameId' => 'THE_TOURIST',
    'name' => clienttranslate('the tourist'),
    'nametr' => self::_('the tourist'),
    'tastes' => array($FRUIT, $CAKE, $CHOCOLATE),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => "BLACK_FOREST_CAKE",
    'favourite2' => null,
  ),
  23 => array(
    'nameId' => 'WALLY',
    'name' => 'Wally',
    'nametr' => 'Wally',
    'tastes' => array($COOOKIE, $CHOCOLATE, $NUTS),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "WALNUT_BROWNIES",
    'favourite2' => null,
  ),
  24 => array(
    'nameId' => 'THE_PROFESSOR',
    'name' => clienttranslate('the professor'),
    'nametr' => self::_('the professor'),
    'tastes' => array($FRUIT, $CAKE),
    'dislike1' => $CHOCOLATE,
    'color' => $BLUE,
    'favourite1' => "STRAWBERRY_SHORTCAKE",
    'favourite2' => "PINEAPPLE_UPSIDE_DOWN_CAKE",
  ),

  /*******************Bacon expansion******************/
  25 => array(
    'nameId' => 'KEVIN',
    'name' => clienttranslate('Kevin'),
    'nametr' => self::_('Kevin'),
    'tastes' => array($CHOCOLATE, $BACON, $CAKE),
    'dislike1' => null,
    'color' => $BURGUNDY,
    'favourite1' => "CHOCOLATE_BACON_CUPCAKES",
    'favourite2' => null,
  ),
  26 => array(
    'nameId' => 'ABRAHAM_BACON',
    'name' => clienttranslate('Abraham Bacon'),
    'nametr' => self::_('Abraham Bacon'),
    'tastes' => array($BACON),
    'dislike1' => null,
    'color' => $BURGUNDY,
    'favourite1' => "ANYTHING_WITH_BACON",
    'favourite2' => null,
  ),
  27 => array(
    'nameId' => 'THE_FARMER',
    'name' => clienttranslate('the farmer'),
    'nametr' => self::_('the farmer'),
    'tastes' => array($COOOKIE, $CHOCOLATE, $BACON),
    'dislike1' => null,
    'color' => $BURGUNDY,
    'favourite1' => "BACON_CHIP_COOKIES",
    'favourite2' => null,
  ),
  28 => array(
    'nameId' => 'THE_VEGETARIAN',
    'name' => clienttranslate('the vegetarian'),
    'nametr' => self::_('the vegetarian'),
    'tastes' => array($FRUIT, $CHOCOLATE),
    'dislike1' => $BACON,
    'dislike2' => $MARSHMALLOW,
    'color' => $BURGUNDY,
    'favourite1' => "CHOCOLATE_DIPPED_STRAWBERRIES",
    'favourite2' => null,
  ),

  /*******************Coffee expansion******************/
  29 => array(
    'nameId' => 'DOCTOR_COFFEE',
    'name' => clienttranslate('Doctor Coffee'),
    'nametr' => self::_('Doctor Coffee'),
    'tastes' => array($COFFEE),
    'dislike1' => null,
    'color' => $ROSE,
    'favourite1' => "ANYTHING_WITH_COFFEE",
    'favourite2' => null,
  ),
  30 => array(
    'nameId' => 'THE_MOVIE_STAR',
    'name' => clienttranslate('the movie star'),
    'nametr' => self::_('the movie star'),
    'tastes' => array($COFFEE, $CAKE, $CHOCOLATE),
    'dislike1' => null,
    'color' => $ROSE,
    'favourite1' => "TIRAMISU",
    'favourite2' => null,
  ),
  31 => array(
    'nameId' => 'CONCEPTUAL_ARTIST',
    'name' => clienttranslate('the conceptual artist'),
    'nametr' => self::_('the conceptual artist'),
    'tastes' => array($CAKE, $SPICES, $NUTS),
    'dislike1' => null,
    'color' => $ROSE,
    'favourite1' => "COFFEE_CAKE",
    'favourite2' => null,
  ),
  32 => array(
    'nameId' => 'MS_JITTERS',
    'name' => clienttranslate('Mr. Jitters'),
    'nametr' => self::_('Mr. Jitters'),
    'tastes' => array($COFFEE, $CHOCOLATE),
    'dislike1' => $FRUIT,
    'color' => $ROSE,
    'favourite1' => "CHOCOLATE_ESPRESSO_BEANS",
    'favourite2' => null,
  ),
);
