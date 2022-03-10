<?php

namespace VitalHCF\Task;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\listeners\interact\Gapple;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class GappleTask extends Task {
	
	/** @var Player */
	protected $player;
	
	/**
	 * GappleTask Constructor.
	 * @param String $player|null
	 */
	public function __construct(?String $player){
		$this->player = $player;
	}
	
	/**
	 * @param Int $currentTick
	 */
	public function onRun(Int $currentTick){
		$playerName = $this->player;
		if(Loader::$appleenchanted[$playerName]["time"] < time()){
			Gapple::removeGappleCooldown($playerName);
			Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
		}
	}
}

?>