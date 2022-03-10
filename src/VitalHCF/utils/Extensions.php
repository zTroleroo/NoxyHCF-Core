<?php

namespace VitalHCF\utils;


use VitalHCF\kit\KitMenu;
use VitalHCF\KOTH\KOTHManager;
use VitalHCF\level\LevelManager;
use VitalHCF\Loader;
use VitalHCF\player\Player;

class Extensions {
    public static function getLevelManager(): LevelManager {
        return new LevelManager(Loader::getInstance());
    }

    public static function getKitManager() : KitMenu {
        return new KitMenu();
    }
}