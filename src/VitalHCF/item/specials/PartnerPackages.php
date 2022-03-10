<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;

use VitalHCF\packages\PackageManager;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\item\ItemFactory;

class PartnerPackages extends Custom {

    const CUSTOM_ITEM = "CustomItem";

    /**
	 * PartnerPackages Constructor.
	 */
	public function __construct(){
		parent::__construct(self::ENDER_CHEST, TE::BOLD.TE::AQUA."Partner Packages", ["\n\n".TE::GRAY."Can get rewards by opening this Box"]);
		$this->setNamedTagEntry(new CompoundTag(self::CUSTOM_ITEM));
	}
}

?>