<?php

namespace VitalHCF\item\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\utils\TextFormat as TE;
use pocketmine\nbt\tag\CompoundTag;

class Firework extends Custom {

    const CUSTOM_ITEM = "CustomItem";

    /**
     * Firework constructor.
     */
    public function __construct(){
        parent::__construct(self::FIREWORKS, "Firework", [TE::GREEN.TE::BOLD."RARE ITEM".TE::RESET."\n\n".TE::GRAY."Raises you blocks up, so you can escape"]);
        $this->setNamedTagEntry(new CompoundTag(self::CUSTOM_ITEM));
    }
}

?>