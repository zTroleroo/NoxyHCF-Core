<?php

namespace VitalHCF\Task;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class RogueTask extends Task {

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
            if(!$player instanceof Player && count(Loader::getInstance()->getServer()->getOnlinePlayers()) < 0) return;
            if($player->isBackStap()){
                if($player->getBackstapTime() === 8){
                    $player->setBackstap(false);
                }else{
                    $player->setBackstapTime($player->getBackstapTime() - 8);
                }
            }
        }
    }
}

?>