<?php

/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * JustDesserts implementation : © <Your name here> <Your email address here>
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
$this->colors = [$BLUE, $GREEN, $RED, $PURPLE, $ORANGE, $YELLOW];

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
$this->flavours = [$CHOCOLATE, $COOOKIE, $NUTS, $PIE, $SPICES, $ICE_CREAM, $FRUIT, $CAKE, $MARSHMALLOW, $PASTRY, $VEGGIES, $PUDDING];

$this->desserts = array(
  1 => array(
    'name' => clienttranslate('BLACK_FOREST_CAKE'),
    'nametr' => self::_('blackForestCake'),
    'tastes' => array($CHOCOLATE, $FRUIT, $CAKE),
  ),
  2 => array(
    'name' => clienttranslate('BOSTON_CREAM_PIE'),
    'nametr' => self::_('bostonCreamPie'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
  ),
  3 => array(
    'name' => clienttranslate('BUTTER_PECAN_ICE_CREAM'),
    'nametr' => self::_('butterPecanIceCream'),
    'taste1' => $NUTS,
    'taste2' => $ICE_CREAM,
    'taste3' => null,
    'taste4' => null,
  ),
  4 => array(
    'name' => clienttranslate('BUTTER_PECAN_ICE_CREAM'),
    'nametr' => self::_('butterPecanIceCream'),
    'tastes' => array($NUTS, $ICE_CREAM),
  ),
  5 => array(
    'name' => clienttranslate('CAKE_DONUT_WITH_SPRINKLES'),
    'nametr' => self::_('cakeDonutWithSprinkles'),
    'tastes' => array($CAKE, $PASTRY),
  ),
  6 => array(
    'name' => clienttranslate('CANDIED_GINGER'),
    'nametr' => self::_('candiedGinger'),
    'tastes' => array($SPICES),
  ),
  7 => array(
    'name' => clienttranslate('CANDIED_YAMS'),
    'nametr' => self::_('candiedYams'),
    'tastes' => array($MARSHMALLOW, $VEGGIES),
  ),
  8 => array(
    'name' => clienttranslate('CARAMEL_NUT_TORTE'),
    'nametr' => self::_('caramelNutTorte'),
    'tastes' => array($NUTS, $CAKE),
  ),
  9 => array(
    'name' => clienttranslate('CARROT_CAKE'),
    'nametr' => self::_('carrotCake'),
    'tastes' => array($CAKE, $VEGGIES),
  ),
  10 => array(
    'name' => clienttranslate('CHEESECAKE'),
    'nametr' => self::_('cheesecake'),
    'tastes' => array($PIE),
  ),
  11 => array(
    'name' => clienttranslate('AMBROSIA_SALAD'),
    'nametr' => self::_('ambrosiaSalad'),
    'tastes' => array($MARSHMALLOW, $FRUIT),
  ),
  12 => array(
    'name' => clienttranslate('CHERRY_PIE'),
    'nametr' => self::_('cherryPie'),
    'tastes' => array($FRUIT, $PIE),
  ),
  13 => array(
    'name' => clienttranslate('CHOCOLATE_ANGEL_FOOD_CAKE'),
    'nametr' => self::_('chocolateAngelFoodCake'),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  14 => array(
    'name' => clienttranslate('CHOCOLATE_CANDY_BAR'),
    'nametr' => self::_('chocolateCandyBar'),
    'tastes' => array($CHOCOLATE),
  ),
  15 => array(
    'name' => clienttranslate('CHOCOLATE_CHIPS_COOKIES'),
    'nametr' => self::_('chocolateChipsCookies'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  16 => array(
    'name' => clienttranslate('CHOCOLATE_COVERED_MARSHMALLOWS'),
    'nametr' => self::_('chocolateCoveredMarshmallows'),
    'tastes' => array($MARSHMALLOW, $CHOCOLATE),
  ),
  17 => array(
    'name' => clienttranslate('CHOCOLATE_CREAM_PIE'),
    'nametr' => self::_('chocolateCreamPie'),
    'tastes' => array($CHOCOLATE, $PIE, $PUDDING),
  ),
  18 => array(
    'name' => clienttranslate('CHOCOLATE_DIPPED_STRAWBERRIES'),
    'nametr' => self::_('chocolateDippedStrawberries'),
    'tastes' => array($CHOCOLATE, $FRUIT),
  ),
  19 => array(
    'name' => clienttranslate('CHOCOLATE_ECLAIR'),
    'nametr' => self::_('chocolateEclair'),
    'tastes' => array($CHOCOLATE, $PUDDING, $PASTRY),
  ),
  20 => array(
    'name' => clienttranslate('CHOCOLATE_FONDUE'),
    'nametr' => self::_('chocolateFondue'),
    'tastes' => array($CHOCOLATE, $FRUIT, $MARSHMALLOW),
  ),
  21 => array(
    'name' => clienttranslate('CHOCOLATE_FROSTED_DONUTS'),
    'nametr' => self::_('chocolateFrostedDonut'),
    'tastes' => array($CHOCOLATE, $PASTRY),
  ),
  22 => array(
    'name' => clienttranslate('APPLE_PIE_A_LA_MODE'),
    'nametr' => self::_('applePieALaMode'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
  ),
  23 => array(
    'name' => clienttranslate('CHOCOLATE_MOUSSE'),
    'nametr' => self::_('chocolateMousse'),
    'tastes' => array($CHOCOLATE, $PUDDING),
  ),
  24 => array(
    'name' => clienttranslate('CHOCOLATE_SANDWICH_COOKIE'),
    'nametr' => self::_('chocolateSandwichCookie'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
  ),
  25 => array(
    'name' => clienttranslate('CINNAMON_ROLL'),
    'nametr' => self::_('cinnamonRoll'),
    'tastes' => array($SPICES, $PASTRY),
  ),
  26 => array(
    'name' => clienttranslate('COCONUT_CUSTARD_PIE'),
    'nametr' => self::_('coconutCustardPie'),
    'tastes' => array($NUTS, $PUDDING, $PIE),
  ),
  27 => array(
    'name' => clienttranslate('COCONUT MACAROONS'),
    'nametr' => self::_('coconutMacaroons'),
    'tastes' => array($COOOKIE, $NUTS),
  ),
  28 => array(
    'name' => clienttranslate('COFFIE_CAKE'),
    'nametr' => self::_('coffeeCake'),
    'tastes' => array($CAKE, $SPICES, $NUTS),
  ),
  29 => array(
    'name' => clienttranslate('CREME_BRULEE'),
    'nametr' => self::_('cremeBrulee'),
    'tastes' => array($PUDDING),
  ),
  30 => array(
    'name' => clienttranslate('CRISPY_RICE_TREATS'),
    'nametr' => self::_('crispyRiceTreats'),
    'tastes' => array($MARSHMALLOW, $COOOKIE),
  ),
  31 => array(
    'name' => clienttranslate('PROFITEROLLES'),
    'nametr' => self::_('profiterolles'),
    'tastes' => array($ICE_CREAM, $PASTRY),
  ),
  32 => array(
    'name' => clienttranslate('DEVILS_FOOD_CUPCAKES'),
    'nametr' => self::_('devilsFoodCupcakes'),
    'tastes' => array($CHOCOLATE, $CAKE),
  ),
  33 => array(
    'name' => clienttranslate('APPLE_TURNOVER'),
    'nametr' => self::_('appleTurnover'),
    'tastes' => array($PASTRY, $FRUIT),
  ),
  34 => array(
    'name' => clienttranslate('FORTUNE_COOKIES'),
    'nametr' => self::_('fortuneCookies'),
    'tastes' => array($COOOKIE),
  ),
  35 => array(
    'name' => clienttranslate('FRUIT_CAKE'),
    'nametr' => self::_('fruitCake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
  ),
  36 => array(
    'name' => clienttranslate('FRUIT_SALAD'),
    'nametr' => self::_('fruitSalade'),
    'tastes' => array($FRUIT),
  ),
  37 => array(
    'name' => clienttranslate('FUDGE'),
    'nametr' => self::_('fudge'),
    'tastes' => array($CHOCOLATE),
  ),
  38 => array(
    'name' => clienttranslate('GINGERBREAD_DUDES'),
    'nametr' => self::_('gingerbreadDudes'),
    'tastes' => array($SPICES, $COOOKIE),
  ),
  39 => array(
    'name' => clienttranslate('GLAZED_DONUT'),
    'nametr' => self::_('glazedDonut'),
    'tastes' => array($PASTRY),
  ),
  40 => array(
    'name' => clienttranslate('HOT_FUDGE_SUNDAE'),
    'nametr' => self::_('hotFudgeSundae'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  41 => array(
    'name' => clienttranslate('ICE_CREAM_CAKE'),
    'nametr' => self::_('iceCreamCake'),
    'tastes' => array($ICE_CREAM, $CAKE),
  ),
  42 => array(
    'name' => clienttranslate('ICE_CREAM_CONE'),
    'nametr' => self::_('iceCreamCone'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
  ),
  43 => array(
    'name' => clienttranslate('ICE_CREAM_SANDWICH'),
    'nametr' => self::_('iceCreamSandwich'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
  ),
  44 => array(
    'name' => clienttranslate('BAKED_ALASKA'),
    'nametr' => self::_('bakedAlaska'),
    'tastes' => array($CHOCOLATE, $CAKE, $FRUIT, $ICE_CREAM),
  ),
  45 => array(
    'name' => clienttranslate('LEMON_COOKIE_SQUARES'),
    'nametr' => self::_('lemonCookieSquares'),
    'tastes' => array($FRUIT, $COOOKIE),
  ),
  46 => array(
    'name' => clienttranslate('MINT_CHOCOLATE_MILK_SHAKE'),
    'nametr' => self::_('milkChocolateMilkShake'),
    'tastes' => array($CHOCOLATE, $ICE_CREAM),
  ),
  47 => array(
    'name' => clienttranslate('NAPOLEON'),
    'nametr' => self::_('napoleon'),
    'tastes' => array($PASTRY),
  ),
  48 => array(
    'name' => clienttranslate('ZUCCHINI_MUFFIN'),
    'nametr' => self::_('zucchiniMuffin'),
    'tastes' => array($VEGGIES, $CAKE),
  ),
  49 => array(
    'name' => clienttranslate('OATMEAL_RAISIN_COOKIES'),
    'nametr' => self::_('oatmealRaisinCookies'),
    'tastes' => array($COOOKIE, $FRUIT),
  ),
  50 => array(
    'name' => clienttranslate('ORANGE_SHERBET'),
    'nametr' => self::_('orangeSherbet'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  51 => array(
    'name' => clienttranslate('PEACH_COBBLER'),
    'nametr' => self::_('peachCobbler'),
    'tastes' => array($PIE, $FRUIT),
  ),
  52 => array(
    'name' => clienttranslate('PEANUT_BRITTLE'),
    'nametr' => self::_('peanutBrittle'),
    'tastes' => array($NUTS),
  ),
  53 => array(
    'name' => clienttranslate('PEANUT_BUTTER_COOKIES'),
    'nametr' => self::_('peanutButterCookies'),
    'tastes' => array($NUTS, $COOOKIE),
  ),
  54 => array(
    'name' => clienttranslate('PEANUT_BUTTER_CUPS'),
    'nametr' => self::_('peanutButterCups'),
    'tastes' => array($CHOCOLATE, $NUTS),
  ),
  55 => array(
    'name' => clienttranslate('BAKLAVA'),
    'nametr' => self::_('baklava'),
    'tastes' => array($NUTS, $PASTRY),
  ),
  56 => array(
    'name' => clienttranslate('PECAN_PIE'),
    'nametr' => self::_('pecanPie'),
    'tastes' => array($PIE, $NUTS),
  ),
  57 => array(
    'name' => clienttranslate('PINAPPLE_UPSIDE_DOWN_CAKE'),
    'nametr' => self::_('pineappleUpsideDownCake'),
    'tastes' => array($CAKE, $FRUIT),
  ),
  58 => array(
    'name' => clienttranslate('POUND_CAKE'),
    'nametr' => self::_('poundCake'),
    'tastes' => array($CAKE),
  ),
  59 => array(
    'name' => clienttranslate('PUMPIN_ICE_CREAM'),
    'nametr' => self::_('pumpkinIceCream'),
    'tastes' => array($ICE_CREAM, $VEGGIES),
  ),
  60 => array(
    'name' => clienttranslate('ZUCCHINI_NUT_BREAD'),
    'nametr' => self::_('zucchiniNutBread'),
    'tastes' => array($VEGGIES, $NUTS, $CAKE),
  ),
  61 => array(
    'name' => clienttranslate('PUMPKIN_PIE'),
    'nametr' => self::_('pumkpinPie'),
    'tastes' => array($VEGGIES, $PIE),
  ),
  62 => array(
    'name' => clienttranslate('RHUBARB_CRUMBLE'),
    'nametr' => self::_('rhubarbCrumble'),
    'tastes' => array($VEGGIES, $PASTRY),
  ),
  63 => array(
    'name' => clienttranslate('SMORES'),
    'nametr' => self::_('smores'),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
  ),
  64 => array(
    'name' => clienttranslate('SHOO_FLY_PIE'),
    'nametr' => self::_('shooFlyPie'),
    'tastes' => array($PIE),
  ),
  65 => array(
    'name' => clienttranslate('SPICE_CAKE'),
    'nametr' => self::_('spiceCake'),
    'tastes' => array($SPICES, $CAKE),
  ),
  66 => array(
    'name' => clienttranslate('BANANA_PUDDING'),
    'nametr' => self::_('bananaPudding'),
    'tastes' => array($FRUIT, $PUDDING, $COOOKIE),
  ),
  67 => array(
    'name' => clienttranslate('STRAWBERRY_ICE_CREAM'),
    'nametr' => self::_('strawberryIceCream'),
    'tastes' => array($FRUIT, $ICE_CREAM),
  ),
  68 => array(
    'name' => clienttranslate('STRAWBERRY_SHORTCAKE'),
    'nametr' => self::_('strawberryShortcake'),
    'tastes' => array($FRUIT, $CAKE),
  ),
  69 => array(
    'name' => clienttranslate('SUGAR_COOKIES'),
    'nametr' => self::_('sugarCookies'),
    'tastes' => array($COOOKIE),
  ),
  70 => array(
    'name' => clienttranslate('TAPIOCA_PUDDING'),
    'nametr' => self::_('tapiocaPudding'),
    'tastes' => array($PUDDING),
  ),
  71 => array(
    'name' => clienttranslate('TOASTED_MARSHMALLOWS'),
    'nametr' => self::_('toastedMarshmallows'),
    'tastes' => array($MARSHMALLOW),
  ),
  72 => array(
    'name' => clienttranslate('VANILLA_ICE_CREAM'),
    'nametr' => self::_('vanillaIceCream'),
    'tastes' => array($ICE_CREAM),
  ),
  73 => array(
    'name' => clienttranslate('WALNUT_BROWNIE'),
    'nametr' => self::_('walnutBrownie'),
    'tastes' => array($CHOCOLATE, $NUTS, $COOOKIE),
  ),
  74 => array(
    'name' => clienttranslate('YELLOW_CAKE'),
    'nametr' => self::_('yelloCake'),
    'tastes' => array($CAKE),
  ),
  75 => array(
    'name' => clienttranslate('BANANA_SPLIT'),
    'nametr' => self::_('bananaSplit'),
    'tastes' => array($CHOCOLATE, $FRUIT, $ICE_CREAM),
  ),
  76 => array(
    'name' => clienttranslate('BELGIAN_WAFFLE'),
    'nametr' => self::_('belgianWaffles'),
    'tastes' => array($FRUIT, $PASTRY),
  )
);

$this->guests = array(
  1 => array(
    'name' => clienttranslate('AGENT_17'),
    'nametr' => self::_('agent17'),
    'tastes' => array($PASTRY, $FRUIT),
    'dislike1' => $NUTS,
    'color' => $RED,
    'favourite1' => "APPLE_TURNOVER",
    'favourite2' => "BELGIAN WAFFLE",
  ),
  2 => array(
    'name' => clienttranslate('BOB_FRUITCAKE'),
    'nametr' => self::_('bobFruitcake'),
    'tastes' => array($FRUIT, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "FRUITCAKE",
    'favourite2' => null,
  ),
  3 => array(
    'name' => clienttranslate('BOSTON_GUY'),
    'nametr' => self::_('bostonGuy'),
    'tastes' => array($CAKE, $PUDDING, $PIE, $CHOCOLATE),
    'dislike1' => null,
    'color' => $GREEN,
    'favourite1' => "BOSTON_CREAM_PIE",
    'favourite2' => null,
  ),
  4 => array(
    'name' => clienttranslate('CANDICE'),
    'nametr' => self::_('candice'),
    'tastes' => array($MARSHMALLOW, $VEGGIES),
    'dislike1' => $CHOCOLATE,
    'color' => $PURPLE,
    'favourite1' => "CANDIED_YAMS",
    'favourite2' => null,
  ),
  5 => array(
    'name' => clienttranslate('FUZZY'),
    'nametr' => self::_('fuzzy'),
    'tastes' => array($CHOCOLATE, $NUTS),
    'dislike1' => $MARSHMALLOW,
    'color' => $GREEN,
    'favourite1' => "PEANUT_BUTTER_CUPS",
    'favourite2' => null,
  ),
  6 => array(
    'name' => clienttranslate('INGA'),
    'nametr' => self::_('inga'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $COOOKIE),
    'dislike1' => null,
    'color' => $GREEN,
    'favourite1' => "ICE_CREAM_SANDWICH",
    'favourite2' => null,
  ),
  7 => array(
    'name' => clienttranslate('MARY_ANN'),
    'nametr' => self::_('maryAnn'),
    'tastes' => array($PIE, $PUDDING, $NUTS),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "COCONUT_CUSTARD_PIE",
    'favourite2' => null,
  ),
  8 => array(
    'name' => clienttranslate('MOJO'),
    'nametr' => self::_('mojo'),
    'tastes' => array($FRUIT, $CAKE, $ICE_CREAM, $CHOCOLATE),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "BAKED_ALASKA",
    'favourite2' => null,
  ),
  9 => array(
    'name' => clienttranslate('MR_HEALTHY'),
    'nametr' => self::_('mrHealthy'),
    'tastes' => array($VEGGIES, $PIE),
    'dislike1' => $CHOCOLATE,
    'color' => $ORANGE,
    'favourite1' => "PUMPKIN_PIE",
    'favourite2' => null,
  ),
  10 => array(
    'name' => clienttranslate('MRS_JENKINS'),
    'nametr' => self::_('mrsJenkins'),
    'tastes' => array($VEGGIES, $CAKE, $NUTS),
    'dislike1' => null,
    'color' => $RED,
    'favourite1' => "ZUCCHINI_NUT_BREAD",
    'favourite2' => null,
  ),
  11 => array(
    'name' => clienttranslate('GRANNY'),
    'nametr' => self::_('granny'),
    'tastes' => array($FRUIT, $PIE, $ICE_CREAM),
    'dislike1' => null,
    'color' => $BLUE,
    'favourite1' => "APPLE_PIE_A_LA_MODE",
    'favourite2' => null,
  ),
  12 => array(
    'name' => clienttranslate('NATURE_GIRL'),
    'nametr' => self::_('natureGirl'),
    'tastes' => array($FRUIT, $SPICES, $VEGGIES),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => null,
    'favourite2' => null,
  ),
  13 => array(
    'name' => clienttranslate('ROLAND'),
    'nametr' => self::_('roland'),
    'tastes' => array($SPICES, $PASTRY),
    'dislike1' => $FRUIT,
    'color' => $GREEN,
    'favourite1' => "CINNAMON_ROLL",
    'favourite2' => null,
  ),
  14 => array(
    'name' => clienttranslate('THE_ASTRONAUT'),
    'nametr' => self::_('theAstronaut'),
    'tastes' => array($CHOCOLATE, $COOOKIE),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "CHOCOLATE_CHIPS_COOKIES",
    'favourite2' => "CHOCOLATE_SANDWICH_COOKIES",
  ),
  15 => array(
    'name' => clienttranslate('THE_DUDE'),
    'nametr' => self::_('theDude'),
    'tastes' => array($FRUIT, $CHOCOLATE, $MARSHMALLOW),
    'dislike1' => null,
    'color' => $YELLOW,
    'favourite1' => "CHOCOLATE_FONDUE",
    'favourite2' => null,
  ),
  16 => array(
    'name' => clienttranslate('THE_EMPEROR'),
    'nametr' => self::_('theEmperor'),
    'tastes' => array($CAKE, $CHOCOLATE),
    'dislike1' => $FRUIT,
    'dislike2' => $VEGGIES,
    'color' => $YELLOW,
    'favourite1' => "DEVILS_FOOD_CUPCAKES",
    'favourite2' => "CHOCOLATE_ANGEL_FOOD_CAKE",
  ),
  17 => array(
    'name' => clienttranslate('THE_HERMIT'),
    'nametr' => self::_('theErmit'),
    'tastes' => array($CHOCOLATE, $PASTRY, $PUDDING),
    'dislike1' => null,
    'color' => $YELLOW,
    'favourite1' => "CHOCOLATE_ECLAIR",
    'favourite2' => null,
  ),
  18 => array(
    'name' => clienttranslate('THE_HIPPIE'),
    'nametr' => self::_('theHippie'),
    'tastes' => array($ICE_CREAM, $CHOCOLATE, $FRUIT),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => "BANANA_SPLIT",
    'favourite2' => null,
  ),
  19 => array(
    'name' => clienttranslate('THE_LITTLE_BOY'),
    'nametr' => self::_('theLittleBoy'),
    'tastes' => array($CHOCOLATE, $MARSHMALLOW, $COOOKIE),
    'dislike1' => null,
    'color' => $RED,
    'favourite1' => "SMORES",
    'favourite2' => null,
  ),
  20 => array(
    'name' => clienttranslate('THE_LITTLE_GIRL'),
    'nametr' => self::_('theLittleGirl'),
    'tastes' => array($ICE_CREAM, $CAKE),
    'dislike1' => $VEGGIES,
    'color' => $RED,
    'favourite1' => "ICE_CREAM_CAKE",
    'favourite2' => null,
  ),
  21 => array(
    'name' => clienttranslate('THE_LUMBERJACK'),
    'nametr' => self::_('theLumberjack'),
    'tastes' => array($ICE_CREAM, $COOOKIE),
    'dislike1' => $NUTS,
    'color' => $YELLOW,
    'favourite1' => "ICE_CREAM_CONE",
    'favourite2' => null,
  ),
  22 => array(
    'name' => clienttranslate('THE_TOURIST'),
    'nametr' => self::_('theTourist'),
    'tastes' => array($FRUIT, $CAKE, $CHOCOLATE),
    'dislike1' => null,
    'color' => $ORANGE,
    'favourite1' => "BLACK_FOREST_CAKE",
    'favourite2' => null,
  ),
  23 => array(
    'name' => clienttranslate('WALLY'),
    'nametr' => self::_('wally'),
    'tastes' => array($COOOKIE, $CHOCOLATE, $NUTS),
    'dislike1' => null,
    'color' => $PURPLE,
    'favourite1' => "WALNUT_BROWNIES",
    'favourite2' => null,
  ),
  24 => array(
    'name' => clienttranslate('THE_PROFESSOR'),
    'nametr' => self::_('bobFruitcake'),
    'tastes' => array($FRUIT, $CAKE),
    'dislike1' => $CHOCOLATE,
    'color' => $BLUE,
    'favourite1' => "STRAWBERRY_SHORTCAKE",
    'favourite2' => "PINEAPPLE_UPSIDE_DOWN_CAKE",
  ),
);
