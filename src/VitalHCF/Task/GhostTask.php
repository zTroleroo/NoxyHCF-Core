<?php

namespace VitalHCF\Task;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\Player;

use pocketmine\item\{Item, ItemIds};
use pocketmine\entity\{Effect, EffectInstance};


use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class GhostTask extends Task {
    /**
     * RogueTask Constructor.
     */
    public function __construct(){
        
    }

    /**
     * @param Int $currentTick
     * @return void
     */
    public function onRun(Int $currentTick) : void {
        foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $player){
          $player->checkClass();
          if($player->isGhostClass() && $player->getGhostEnergy() < 120){
				$player->setGhostEnergy($player->getGhostEnergy() + 1);
	            if(Factions::inFaction($player->getName())){
	                switch($player->getInventory()->getItemInHand()->getId()){
	                    case ItemIds::SUGAR:
	                    	if(Factions::isSpawnRegion($player)) return;
	                        foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
	                            $online = Loader::getInstance()->getServer()->getPlayer($value);
	                            if($online instanceof Player && $online->distanceSquared($player) < 250){
	                                $online->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 10, 3));
	                            }
	                        }
	                    break;
	                }
	            }
	        }
	    }
	}
}

?>
	
	                    	
	                                
            