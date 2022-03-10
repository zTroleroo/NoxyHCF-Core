<?php

namespace VitalHCF\Task\event;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\listeners\event\PP;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class PPTask extends Task {
	
	/**
	 * PPTask Constructor.
	 * @param Int $time
	 */
	public function __construct(Int $time = 60){
		PP::setTime($time);
	}
	
	/**
	 * @param Int $currentTick
	 * @return void
	 */
	public function onRun(Int $currentTick) : void {
		if(!PP::isEnable()){
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
			return;
		}
		foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $online){
			$online->hidePlayer($online);
		}
		if(PP::getTime() === 0){
			foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $online){
				$online->showPlayer($online);
			}
			PP::setEnable(false);
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
		}else{
			PP::setTime(PP::getTime() - 1);
		}
	}
}

?>