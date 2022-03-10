<?php

namespace VitalHCF\listeners;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\Player;

use pocketmine\item\ItemIds;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as TE;

use pocketmine\event\player\{PlayerInteractEvent, PlayerMoveEvent};
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};

use pocketmine\block\{ItemFrame, Door, Fence, FenceGate, Trapdoor, Chest, TrappedChest};
use pocketmine\item\{Bucket, Hoe, Shovel};

class Spawn implements Listener {
	
	/**
	 * Spawn Constructor.
	 */
	public function __construct(){
		
	}
	
	/**
	 * @param PlayerInteractEvent $event
	 * @return void
	 */
	public function onPlayerInteractEvent(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$item = $event->getItem();
		if($player->getLevel() === Loader::getInstance()->getServer()->getDefaultLevel()){
			if($player->isGodMode()) return;
			if($block instanceof Fence||$block instanceof FenceGate||$block instanceof Door||$block instanceof Trapdoor||$block instanceof Chest||$item instanceof Bucket||$item instanceof Hoe||$item instanceof Shovel||$item instanceof ItemFrame){
				$spawn = new Vector3(0, 0, 0);
				if((int)$spawn->distance($event->getBlock()) < Loader::getDefaultConfig("FactionsConfig")["Wilderness"]){
					$event->setCancelled(true);
				}
			}
		}
		if($player->getLevel()->getName() === Loader::getDefaultConfig("LevelManager")["levelEndName"]){
			if($player->isGodMode()) return;
			if($block instanceof Fence||$block instanceof FenceGate||$block instanceof Door||$block instanceof Trapdoor||$block instanceof Chest||$item instanceof Bucket||$item instanceof Hoe||$item instanceof Shovel||$item instanceof ItemFrame){
				$event->setCancelled(true);
			}
		}
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * @return void
	 */
	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		if($player->getLevel() === Loader::getInstance()->getServer()->getDefaultLevel()){
			if($player->isGodMode()) return;
			$spawn = new Vector3(0, 0, 0);
			if((int)$spawn->distance($event->getBlock()) < Loader::getDefaultConfig("FactionsConfig")["Wilderness"]){
				$event->setCancelled(true);
			}
		}
		if($player->getLevel()->getName() === Loader::getDefaultConfig("LevelManager")["levelEndName"]){
			if($player->isGodMode()) return;
			$event->setCancelled(true);
		}
	}
	
	/**
	 * @param BlockPlaceEvent $event
	 * @return void
	 */
	public function onBlockPlace(BlockPlaceEvent $event){
		$player = $event->getPlayer();
		if($player->getLevel() === Loader::getInstance()->getServer()->getDefaultLevel()){
			$spawn = new Vector3(0, 0, 0);
			if((int)$spawn->distance($event->getBlock()) < Loader::getDefaultConfig("FactionsConfig")["Wilderness"]){
				if($player->isGodMode()) return;
				$event->setCancelled(true);
			}
		}
		if($player->getLevel()->getName() === Loader::getDefaultConfig("LevelManager")["levelEndName"]){
			if($player->isGodMode()) return;
			$event->setCancelled(true);
		}
	}
	
	/**
	 * @param PlayerMoveEvent $event
	 * @return void
	 */
	public function onPlayerMoveEvent(PlayerMoveEvent $event) : void {
		$player = $event->getPlayer();
		if($player instanceof Player){
			if(!$this->isBorderLimit($player)){
				$player->teleport($this->correctPosition($player));
			}
			if(Factions::inFaction($player->getName())){
			  $player->setNameTag(
			      TE::GOLD."[".TE::RED.Factions::getFaction($player->getName()).TE::GRAY." | ".TE::GREEN.Factions::getStrength(Factions::getFaction($player->getName())).TE::GOLD."]\n"
                  .TE::GOLD.$player->getDisplayName());
			  
			}else{
			  $player->setNameTag(TE::RED.$player->getName());
			}
		}
	}
        
	/**
	 * @param Vector3 $position
	 * @return bool
	 */
	protected function isBorderLimit(Vector3 $position) : bool {
		$border = Loader::getDefaultConfig("FactionsConfig")["BorderLimit"];
		return $position->getFloorX() >= -$border && $position->getFloorX() <= $border && $position->getFloorZ() >= -$border && $position->getFloorZ() <= $border;
	}
	
	/**
	 * @param Vector3 $position
	 * @return Vector3
	 */
	protected function correctPosition(Vector3 $position) : Vector3 {
		$border = Loader::getDefaultConfig("FactionsConfig")["BorderLimit"];
		$radius = 2000;
		
		$x = $position->getFloorX();
		$y = $position->getFloorY();
		$z = $position->getFloorZ();
		
		$xMin = -$border;
		$xMax = $border;
		
		$zMin = -$border;
		$zMax = $border;
		
		if($x <= $xMin){
			$x = $xMin + 4;
		}elseif($x >= $xMax){
			$x = $xMax - 4;
		}
		if($z <= $zMin){
			$z = $zMin + 4;
		}elseif($z >= $zMax){
			$z = $zMax - 4;
		}
		$y = 72;
		return new Vector3($x, $y, $z, $position->getLevel());
	}
}

?>