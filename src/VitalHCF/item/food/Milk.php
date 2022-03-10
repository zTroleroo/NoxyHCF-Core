<?php

namespace VitalHCF\item\food;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

use pocketmine\entity\Living;
use pocketmine\item\{Item, ItemFactory};

class Milk extends \pocketmine\item\Food {
	
	/**
	 * Milk Constructor.
	 * @param Int $meta
	 */
	public function __construct(Int $meta = 1){
		parent::__construct(\pocketmine\item\Item::BUCKET, $meta, "Milk");
	}

    /**
     * @param Living $consumer
     */
    public function onConsume(Living $consumer){
        $consumer->removeAllEffects();
    }

    /**
	 * @return Item
	 */
	public function getResidue(){
		return ItemFactory::get(Item::AIR, 0, 0);
	}

    /**
     * @return bool
     */
    public function requiresHunger() : bool {
		return false;
	}

	/**
	 * @return Int 
	 */
	public function getFoodRestore() : Int {
		return 0;
	}

	/**
	 * @return float 
	 */
	public function getSaturationRestore() : float {
		return 0;
	}
}

?>