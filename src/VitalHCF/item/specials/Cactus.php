<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class Cactus extends Custom {
	
	const CUSTOM_ITEM = "CustomItem";
	
	/**
	 * Resistance Constructor.
	 */
	public function __construct(){
		parent::__construct(self::CACTUS, "Cactus", [TE::GREEN.TE::BOLD."RARE ITEM".TE::RESET."\n\n".TE::GRAY."You can get Strength and Resistance 4 by yourself (4 seconds) "]);
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