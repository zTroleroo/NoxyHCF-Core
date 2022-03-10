<?php

namespace VitalHCF\provider;

use VitalHCF\listeners\interact\Shop;
use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\{Config, TextFormat as TE};
use pocketmine\Server;

use VitalHCF\kit\KitBackup;
use VitalHCF\crate\CrateBackup;
use VitalHCF\shop\ShopBackup;
use VitalHCF\koth\KothBackup;
use VitalHCF\Citadel\CitadelBackup;
use VitalHCF\packages\PackageBackup;

class YamlProvider {
	
	/**
	 * @return void
	 */
	public static function init() : void {
		self::load();
		if(!is_dir(Loader::getInstance()->getDataFolder())){
			@mkdir(Loader::getInstance()->getDataFolder());
		}
		if(!is_dir(Loader::getInstance()->getDataFolder()."players")){
			@mkdir(Loader::getInstance()->getDataFolder()."players");
		}
		if(!is_dir(Loader::getInstance()->getDataFolder()."backup")){
			@mkdir(Loader::getInstance()->getDataFolder()."backup");
		}
		Loader::getInstance()->saveResource("config.yml");
		Loader::getInstance()->saveResource("messages.yml");
		Loader::getInstance()->saveResource("permissions.yml");
		Loader::getInstance()->saveResource("scoreboard_settings.yml");
		Loader::getInstance()->saveResource("bot_settings.yml");
		Loader::getInstance()->getLogger()->info(TE::GREEN."YamlProvider » was loaded successfully!");
	}
	
	/**
	 * @return void
	 */
	public static function load() : void {
		try {
			$appleenchanted = (new Config(Loader::getInstance()->getDataFolder()."cooldowns.yml", Config::YAML))->getAll();
			if(!empty($appleenchanted)){
				Loader::$appleenchanted = $appleenchanted;
			}
			KitBackup::initAll();
			CrateBackup::initAll();
			ShopBackup::initAll();
			KothBackup::initAll();
			CitadelBackup::initAll();
			PackageBackup::initAll();

		} catch (\Exception $exception) {
			Loader::getInstance()->getLogger()->error($exception->getMessage());
		}
	}
	
	/**
	 * @return void
	 */
	public static function save() : void {
		try {
			if(!empty(Loader::$appleenchanted)){
                $file = new Config(Loader::getInstance()->getDataFolder()."cooldowns.yml", \pocketmine\utils\Config::YAML);
                $file->setAll(Loader::$appleenchanted);
                $file->save();
            }
			KitBackup::saveAll();
			CrateBackup::saveAll();
			ShopBackup::saveAll();
			KothBackup::saveAll();
			CitadelBackup::saveAll();
			PackageBackup::saveAll();

		} catch (\Exception $exception) {
			Loader::getInstance()->getLogger()->error($exception->getMessage());
		}
	}
}

?>