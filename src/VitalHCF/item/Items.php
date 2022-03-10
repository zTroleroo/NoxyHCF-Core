<?php

namespace VitalHCF\item;

use VitalHCF\item\specials\{Firework,
    SecondChance,
    RemoveEffect,
    StormBreaker,
    AntiTrapper,
    EggPorts,
    Strength,
	TankMode,
    Resistance,
    Invisibility,
    PotionCounter,
    NinjaShear,
    LoggerBait,
    Cocaine,
    Cactus,
    RageBall,
    PartnerPackages,
    ZombieBardItem
};

use VitalHCF\item\netherite\{Helmet, Chestplate, Leggings, Boots, Sword, Pickaxe};

use pocketmine\item\{Item, ItemFactory};

class Items {

	const NETHERITE_HELMET = 748, NETHERITE_CHESTPLATE = 749, NETHERITE_LEGGINGS = 750, NETHERITE_BOOTS = 751, NETHERITE_SWORD = 743, NETHERITE_PICKAXE = 745;
	
	/**
	 * @return void
	 */
	public static function init() : void {
		ItemFactory::registerItem(new EnderPearl(), true);
		ItemFactory::registerItem(new FishingRod(), true);
		ItemFactory::registerItem(new SplashPotion(), true);
		ItemFactory::registerItem(new GoldenApple(), true);
		ItemFactory::registerItem(new GoldenAppleEnchanted(), true);
		ItemFactory::registerItem(new EnderEye(), true);

		ItemFactory::registerItem(new Helmet(), true);
		ItemFactory::registerItem(new Chestplate(), true);
		ItemFactory::registerItem(new Leggings(), true);
		ItemFactory::registerItem(new Boots(), true);
		ItemFactory::registerItem(new Sword(), true);
		ItemFactory::registerItem(new Pickaxe(), true);
		
		ItemFactory::registerItem(new StormBreaker(), true);
		ItemFactory::registerItem(new SecondChance(), true);
		ItemFactory::registerItem(new AntiTrapper(), true);
		ItemFactory::registerItem(new EggPorts(), true);
		ItemFactory::registerItem(new Strength(), true);
		ItemFactory::registerItem(new Resistance(), true);
		ItemFactory::registerItem(new NinjaShear(), true);
		ItemFactory::registerItem(new Resistance(), true);
		ItemFactory::registerItem(new Strength(), true);
        
ItemFactory::registerItem(new RageBall(), true);

		ItemFactory::registerItem(new Invisibility(), true);
		ItemFactory::registerItem(new PotionCounter(), true);
		ItemFactory::registerItem(new Firework(), true);
		ItemFactory::registerItem(new ZombieBardItem(), true);

        ItemFactory::registerItem(new PartnerPackages(), true);
        ItemFactory::registerItem(new LoggerBait(), true);

	}

	/**
	 * @param Item $item
	 * @return Array[]
	 */
	public static function itemSerialize(Item $item) : Array {
		$data = $item->jsonSerialize();
		return $data;
	}

	/**
	 * @param Array $items
	 * @return Item
	 */
	public static function itemDeserialize(Array $items) : Item {
		$item = Item::jsonDeserialize($items);
		return $item;
	}
}

?>