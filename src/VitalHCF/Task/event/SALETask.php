<?php

namespace VitalHCF\Task\event;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\listeners\event\SALE;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class SALETask extends Task {
	
	/**
	 * SALETask Constructor.
	 * @param Int $time
	 */
	public function __construct(Int $time = 60){
		SALE::setTime($time);
	}
	
	/**
	 * @param Int $currentTick
	 * @return void
	 */
	public function onRun(Int $currentTick) : void {
		if(!SALE::isEnable()){
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
			return;
		}
		foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $online){
			$online->hidePlayer($online);
		}
		if(SALE::getTime() === 0){
			foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $online){
				$online->showPlayer($online);
			}
			SALE::setEnable(false);
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
		}else{
			SALE::setTime(SALE::getTime() - 1);
		}
	}
}

?>