<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\item\EnderPearl;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class PrePearl extends CustomProjectileItem {
	
	const CUSTOM_ITEM = "CustomItem";
	
	/**
	 * PrePearl Constructor.
	 */
	public function __construct(){
		parent::__construct(self::ENDER_PEARL, "PrePearl", [TE::GREEN.TE::BOLD."RARE ITEM".TE::RESET."\n\n".TE::GRAY."Can return to the position in which you activated the PrePearl"]);
		$this->setNamedTagEntry(new CompoundTag(self::CUSTOM_ITEM));
	}
	
	/**
     * @return Int
     */
    public function getMaxStackSize() : Int {
        return 16;
	}
}

?>