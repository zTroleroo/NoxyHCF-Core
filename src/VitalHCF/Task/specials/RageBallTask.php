<?php


namespace VitalHCF\Task\specials;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class RageBallTask extends Task {

    /**
     * RageBallTask Constructor.
     * @param Player $player
     */
    public function __construct(Player $player){
        $this->player = $player;
        $player->setRageBallTime(Loader::getDefaultConfig("Cooldowns")["RageBall"]);
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
        if($player->getRageBallTime() === 0){
            $player->setRageBall(false);
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            $player->setRageBallTime($player->getRageBallTime() - 1);
        }
    }
}