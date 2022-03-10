<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class SecondChance extends Custom {
	
	const CUSTOM_ITEM = "CustomItem";
	
	/**
	 * SecondChance Constructor.
	 */
	public function __construct(){
		parent::__construct(self::GHAST_TEAR, "Second Chance", [TE::GREEN.TE::BOLD."RARE ITEM".TE::RESET."\n\n".TE::GRAY."Can remove the cooldown from your EnderPearl"]);
		$this->setNamedTagEntry(new CompoundTag(self::CUSTOM_ITEM));
	}
	
	/**
     * @return Int
     */
    public function getMaxStackSize() : Int {
        return 64;
    }
}

?>