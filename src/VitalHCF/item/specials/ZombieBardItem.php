<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class ZombieBardItem extends Custom {
	
	const CUSTOM_ITEM = "CustomItem";
	
	/**
	 * ZombieBard Constructor.
	 */
	public function __construct(){
		parent::__construct(self::GLOWSTONE_DUST, "§6Portable Bard", [TE::GOLD.TE::BOLD."LEGENDARY ITEM".TE::RESET."\n\n".TE::GRAY."Zombie Bard portable, same as the Bard"]);
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