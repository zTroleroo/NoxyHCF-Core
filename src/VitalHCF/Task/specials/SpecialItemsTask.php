<?php

namespace VitalHCF\Task\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class SpecialItemsTask extends Task {

    /**
     * SpecialItemsTask Constructor.
     */
    public function __construct(){
        
    }

    /**
     * @param Int $currentTick
     * @return void
     */
    public function onRun(Int $currentTick) : void {
        foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $player){
            if(!$player instanceof Player && count(Loader::getInstance()->getServer()->getOnlinePlayers()) < 0) return;
            if($player->getNinjaShearTime() === 0){
                $player->setNinjaShear(false);
            }else{
                $player->setNinjaShearTime($player->getNinjaShearTime() - 1);
            }
            if($player->getSecondChanceTime() === 0){
                $player->setSecondChance(false);
            }else{
                $player->setSecondChanceTime($player->getSecondChanceTime() - 1);
            }
        }
    }
}

?>