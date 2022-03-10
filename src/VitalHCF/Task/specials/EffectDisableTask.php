<?php


namespace VitalHCF\Task\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class EffectDisableTask extends Task {

    /**
     * RareBrickTask Constructor.
     * @param Player $player
     */
    public function __construct(Player $player){
        $this->player = $player;
        $player->setEffectDisableTime(Loader::getDefaultConfig("Cooldowns")["EffectDisable"]);
    }

    /**
     * @param Int $currentTick
     * @return void
     */
    public function onRun(Int $currentTick) : void {
        $player = $this->player;
        if(!$player->isOnline()){
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            return;
        }
        if($player->getEffectDisableTime() === 0){
            $player->setEffectDisable(false);
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            $player->setEffectDisableTime($player->getEffectDisableTime()- 1);
        }
    }
}