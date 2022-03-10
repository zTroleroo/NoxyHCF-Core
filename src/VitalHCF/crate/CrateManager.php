<?php

namespace VitalHCF\crate;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\utils\Translator;

use pocketmine\utils\{Config, TextFormat as TE};
use pocketmine\item\{Item, ItemIds};
use pocketmine\item\enchantment\{Enchantment, EnchantmentInstance};

class CrateManager {
	
	/** @var Array[] */
	public static $crate = [];
	
	/**
	 * @param String $crateName
	 * @return bool
	 */
	public static function isCrate(String $crateName) : bool {
		if(isset(self::$crate[$crateName])){
			return true;
		}else{
			return false;
		}
		return false;
	}
	
	/**
	 * @param Array $args
	 * @return void
	 */
	public static function createCrate(Array $args = []) : void {
        self::$crate[$args["name"]] = new Crate($args["name"], $args["contents"], $args["block_id"], $args["key_id"], $args["keyName"], $args["nameFormat"], !empty($args["position"]) ? $args["position"] : null, !empty($args["particles"]) ? $args["particles"] : null);
	}
	
	/**
	 * @param String $crateName
	 * @return void
	 */
	public static function removeCrate(String $crateName) : void {
		unset(self::$crate[$crateName]);
		$file = new Config(Loader::getInstance()->getDataFolder()."backup".DIRECTORY_SEPARATOR."crates.yml", Config::YAML);
		$file->remove($crateName);
		$file->save();
	}

    /**
     * @param Player $player
     * @param String $crateName
     * @param Int $amount
     * @param String $spawned
     */
	public static function giveKey(Player $player, String $crateName, Int $amount = 1, String $spawned = "CONSOLE") : void {
		$crate = self::getCrate($crateName);

		$item = Translator::itemStringToObject($crate->getKey(), $amount);
		$item->setCustomName($crate->getKeyName());
		$item->setLore([TE::GRAY."\nYou can redeem this key at crate\nin the spawn area.\n\nLeft click to view crate rewards.\nRight click to open the crate.".TE::GRAY."\n\nshop.noxypvp.ml\n\n".TE::DARK_GRAY."Spawned By [{$spawned}".TE::DARK_GRAY."]"]);

		$player->getInventory()->addItem($item);
        $player->sendMessage(str_replace(["&", "{keyName}"], ["§", $crate->getKeyName()], Loader::getConfiguration("messages")->get("crate_give_key_correctly")));
	}

	/**
	 * @param String $crateName
	 * @return Crate
	 */
	public static function getCrate(String $crateName) : ?Crate {
		return self::isCrate($crateName) ? self::$crate[$crateName] : null;
	}
	
	/**
	 * @return Array[]
	 */
	public static function getCrates() : Array {
		return self::$crate;
	}
}

?>