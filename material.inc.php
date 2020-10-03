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
    'taste1' => $CHOCOLATE,
    'taste2' => $FRUIT,
    'taste3' => $CAKE,
    'taste4' => null,
  ),
  2 => array(
    'name' => clienttranslate('BOSTON_CREAM_PIE'),
    'nametr' => self::_('bostonCreamPie'),
    'taste1' => $CAKE,
    'taste2' => $PUDDING,
    'taste3' => $PIE,
    'taste4' => $CHOCOLATE,
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
    'name' => clienttranslate('CAKE_DONUT_WITH_SPRINKLES'),
    'nametr' => self::_('cakeDonutWithSprinkles'),
    'taste1' => $CAKE,
    'taste2' => $PASTRY,
    'taste3' => null,
    'taste4' => null,
  ),
  5 => array(
    'name' => clienttranslate('CANDIED_GINGER'),
    'nametr' => self::_('candiedGinger'),
    'taste1' => $SPICES,
    'taste2' => null,
    'taste3' => null,
    'taste4' => null,
  ),
  6 => array(
    'name' => clienttranslate('CANDIED_YAMS'),
    'nametr' => self::_('candiedYams'),
    'taste1' => $MARSHMALLOW,
    'taste2' => $VEGGIES,
    'taste3' => null,
    'taste4' => null,
  )
);

$this->guests = array(
  1 => array(
    'name' => clienttranslate('AGENT_17'),
    'nametr' => self::_('agent17'),
    'taste1' => $PASTRY,
    'taste2' => $FRUIT,
    'taste3' => null,
    'taste4' => null,
    'dislike' => $NUTS,
    'color' => $RED,
    'favourite1' => "APPLE_TURNOVER",
    'favourite2' => "BELGIAN WAFFLE",
  ),
  2 => array(
    'name' => clienttranslate('BOB_FRUITCAKE'),
    'nametr' => self::_('bobFruitcake'),
    'taste1' => $FRUIT,
    'taste2' => $CAKE,
    'taste3' => $NUTS,
    'taste4' => null,
    'dislike' => null,
    'color' => $PURPLE,
    'favourite1' => "FRUITCAKE",
    'favourite2' => null,
  ),
  3 => array(
    'name' => clienttranslate('BOSTON_GUY'),
    'nametr' => self::_('bostonGuy'),
    'taste1' => $CAKE,
    'taste2' => $PUDDING,
    'taste3' => $PIE,
    'taste4' => $CHOCOLATE,
    'dislike' => null,
    'color' => $GREEN,
    'favourite1' => "BOSTON_CREAM_PIE",
    'favourite2' => null,
  )
);
