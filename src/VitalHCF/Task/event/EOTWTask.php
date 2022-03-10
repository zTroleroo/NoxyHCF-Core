<?php

namespace VitalHCF\Task\event;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\listeners\event\EOTW;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class EOTWTask extends Task {
	
	/**
	 * EOTWTask Constructor.
	 * @param Int $time
	 */
	public function __construct(Int $time = 60){
		EOTW::setTime($time);
	}
	
	/**
	 * @param Int $currentTick
	 * @return void
	 */
	public function onRun(Int $currentTick) : void {
		if(!EOTW::isEnable()){
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
			return;
		}
		if(EOTW::getTime() === 0){
			EOTW::setEnable(false);
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
		}else{
			EOTW::setTime(EOTW::getTime() - 1);
		}
	}
}

?>