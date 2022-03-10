<?php

namespace VitalHCF\Task\updater;

use VitalHCF\Loader;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class NinjaShearUpdaterTask extends Task {

    /** @var Player */
    protected $player;

    /** @var Int */
    protected $time = 30;

    /**
     * NinjaShearUpdaterTask Constructor.
     */
    public function __construct(){

    }

    /**
     * @param Int $currentTick
     * @return void
     */
    public function onRun(Int $currentTick) : void {
        # This is the execution to erase the data of the player's position when using the NinjaShear
        foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $player){
            if($this->getTime() === 0){
                $player->setNinjaShearPosition(null);
                $this->time = 30;
            }else{
                $this->setTime($this->getTime() - 1);
            }
        }
    }

    /**
     * @param Int $time
     */
    public function setTime(Int $time){
        $this->time = $time;
    }

    /**
     * @return Int
     */
    public function getTime() : Int {
        return $this->time;
    }
}