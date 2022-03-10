<?php

namespace VitalHCF\Task\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class SecondChanceTask extends Task {

    /** @var Player */
    protected $player;

    /**
     * StrengthTask Constructor.
     * @param Player $player
     */
    public function __construct(Player $player){
        $this->player = $player;
        $player->setSecondChanceTime(Loader::getDefaultConfig("Cooldowns")["SecondChance"]);
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
        if($player->getSecondChanceTime() === 0){
            $player->setSecondChance(false);
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            $player->setSecondChanceTime($player->getSecondChanceTime() - 1);
        }
    }
}

?>