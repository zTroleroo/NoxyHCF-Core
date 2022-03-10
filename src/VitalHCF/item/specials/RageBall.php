<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class RageBall extends Custom {
	
	const CUSTOM_ITEM = "CustomItem";
	
	/**
	 * RageBall Constructor.
	 */
	public function __construct(){
		parent::__construct(self::FIRE_CHARGE, "Rage Ball", [TE::GREEN.TE::BOLD."RARE ITEM".TE::RESET."\n\n".TE::GRAY."You can get Strength 2 and Slowness 2 for 8 seconds "]);
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