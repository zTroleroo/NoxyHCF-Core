<?php

namespace VitalHCF\Task;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class GhostTagTask extends Task {

    /** @var Player */
    protected $player;

    /**
     * GhostTagTask Constructor.
     * @param Player $player
     */
    public function __construct(Player $player){
        $this->player = $player;
        $player->setGhostTagTime(Loader::getDefaultConfig("Cooldowns")["ArcherTag"]);
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
        if(!$player->isGhostTag()){
        	Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        	return;
        }
        if($player->getGhostTagTime() === 0){
            $player->setGhostTag(false);
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            $player->setGhostTagTime($player->getGhostTagTime() - 1);
        }
    }
}

?>