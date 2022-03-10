<?php


namespace VitalHCF\Task\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class LoggerBaitTask extends Task {

    /**
     * LoggerBaitTask Constructor.
     * @param Player $player
     */
    public function __construct(Player $player){
        $this->player = $player;
        $player->setLoggerBaitTime(Loader::getDefaultConfig("Cooldowns")["LoggerBait"]);
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
        if($player->getLoggerBaitTime() === 0){
            $player->setLoggerBait(false);
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            $player->setLoggerBaitTime($player->getLoggerBaitTime() - 1);
        }
    }
}