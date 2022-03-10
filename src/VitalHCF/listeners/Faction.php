<?php

namespace VitalHCF\listeners;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\Player;

use VitalHCF\Task\FreezeTimeTask;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as TE;
use pocketmine\math\Vector3;

use pocketmine\item\{ItemIds, BlockIds};
use pocketmine\block\{SignPost, ItemFrame, Door, FenceGate, Trapdoor, Chest, TrappedChest};
use pocketmine\item\{Bucket, Hoe, Shovel};

use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent, BlockSpreadEvent, SignChangeEvent};
use pocketmine\event\player\{PlayerMoveEvent, PlayerInteractEvent, PlayerJoinEvent, PlayerQuitEvent, PlayerDeathEvent, PlayerChatEvent};

class Faction implements Listener {

    /**
     * Faction Constructor.
     */
    public function __construct(){
		
	}

	/**
	 * @param PlayerJoinEvent $event
	 * @return void
	 */
	public function onPlayerJoinEvent(PlayerJoinEvent $event) : void {
		$player = $event->getPlayer();
		if(Factions::inFaction($player->getName())){
			foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
				$online = Loader::getInstance()->getServer()->getPlayer($value);
				if($online instanceof Player){
					$online->sendMessage(str_replace(["&", "{playerName}"], ["§", $player->getName()], Loader::getConfiguration("messages")->get("faction_player_connect")));
				}
			}
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 * @return void
	 */
	public function onPlayerQuitEvent(PlayerQuitEvent $event) : void {
		$player = $event->getPlayer();
		if(Factions::inFaction($player->getName())){
			foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
				$online = Loader::getInstance()->getServer()->getPlayer($value);
				if($online instanceof Player){
					$online->sendMessage(str_replace(["&", "{playerName}"], ["§", $player->getName()], Loader::getConfiguration("messages")->get("faction_player_desconnect")));
				}
			}
		}
	}

	/**
	 * @param PlayerDeathEvent $event
	 * @return void
	 */
	public function onPlayerDeathEvent(PlayerDeathEvent $event) : void {
		$player = $event->getPlayer();
		if(Factions::inFaction($player->getName())){
			Factions::reduceStrength(Factions::getFaction($player->getName()));
			foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
				$online = Loader::getInstance()->getServer()->getPlayer($value);
				if($online instanceof Player){
					$online->sendMessage(str_replace(["&", "{playerName}", "{currentDtr}", "%n%"], ["§", $player->getName(), Factions::getStrength(Factions::getFaction($player->getName())), "\n"], Loader::getConfiguration("messages")->get("faction_player_death")));
				}
			}
			if(!Factions::isFreezeTime(Factions::getFaction($player->getName()))){
				Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new FreezeTimeTask(Factions::getFaction($player->getName())), 20);
			}
		}
	}
	/**
	 * @param PlayerChatEvent $event
	 * @return void
	 */
	public function onPlayerChatEvent(PlayerChatEvent $event) : void {
		$player = $event->getPlayer();
		if(!$player instanceof Player) return;
		if(Factions::inFaction($player->getName()) && $player->getChat() === Player::ALLY_CHAT){
		    $event->setCancelled(true);
		    if(Factions::getAlly(Factions::getFaction($player->getName())) !== null){
                $allys = Factions::getAlly(Factions::getFaction($player->getName()));
                foreach(Factions::getPlayers($allys) as $playersAlly){
                    $playerAlly = Loader::getInstance()->getServer()->getPlayer((string)$playersAlly);
                    if($playerAlly instanceof Player) {
                        $playerAlly->sendMessage(TE::DARK_GREEN . "[Ally] " . $player->getName() . ": " . $event->getMessage());
                    }
                }
                foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $playersFaction){
                    $playerFaction = Loader::getInstance()->getServer()->getPlayer((string)$playersFaction);
                    if($playerFaction instanceof Player) {
                        $playerFaction->sendMessage(TE::DARK_GREEN . "[Ally] " . $player->getName() . ": " . $event->getMessage());
                    }
                }
            }
        }
		if(Factions::inFaction($player->getName()) && $player->getChat() === Player::FACTION_CHAT){
			$event->setCancelled(true);
			foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
				$online = Loader::getInstance()->getServer()->getPlayer($value);
				if($online instanceof Player){
					$online->sendMessage(str_replace(["&", "{playerName}", "{message}"], ["§", $player->getName(), $event->getMessage()], Loader::getConfiguration("messages")->get("faction_player_chat")));
				}
			}
		}
	}
	
	public function onEntityDamageEvent(EntityDamageEvent $event) : void {
		$player = $event->getEntity();
		if($player instanceof Player){
			if($player->isTeleportingHome()){
				$player->setTeleportingHome(false);
				$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
			}
			if($player->isTeleportingStuck()){
				$player->setTeleportingStuck(false);
				$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
			}
			if($player->isLogout()){
				$player->setLogout(false);
				$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_logout_time")));
			}
		}
		if($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			if($player instanceof Player && $damager instanceof Player){
				if(Factions::inFaction($damager->getName()) && Factions::inFaction($player->getName()) && Factions::getFaction($damager->getName()) === Factions::getFaction($player->getName())){
					$damager->sendMessage(str_replace(["&", "{playerName}"], ["§", $player->getName()], Loader::getConfiguration("messages")->get("faction_not_damage_member")));
					$event->setCancelled(true);
				}else{
					if($player->isTeleportingHome()){
						$player->setTeleportingHome(false);
						$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
					}
					if($player->isTeleportingStuck()){
						$player->setTeleportingStuck(false);
						$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
					}
					if($player->isLogout()){
						$player->setLogout(false);
						$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_logout_time")));
					}
				}
			}
		}
	}
	
	/**
	 * @param PlayerInteractEvent $event
	 * @return void
	 */
	public function onPlayerInteractEvent(PlayerInteractEvent $event) : void {
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$item = $event->getItem();
		if($block instanceof FenceGate||$block instanceof Door||$block instanceof Trapdoor){
			if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
				if(Factions::isFactionRegion($block)){
					if($player->isGodMode()) return;
					if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
						$event->setCancelled(false);
					}else{
						$player->setMovementTime(time() + 0.1);
						$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
						$event->setCancelled(true);
					}
				}
			}
		}
		if($block instanceof Chest){
			if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
				if(Factions::isFactionRegion($block)){
					if($player->isGodMode()) return;
					if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
						$event->setCancelled(false);
					}else{
						$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
						$event->setCancelled(true);
					}
				}
			}
		}
		if($item instanceof Bucket||$item instanceof Hoe||$item instanceof Shovel){
			if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
				if(Factions::isFactionRegion($block)){
					if($player->isGodMode()) return;
					if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
						$event->setCancelled(false);
					}else{
						$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
						$event->setCancelled(true);
					}
				}
			}
		}
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * @return void
	 */
	public function onBlockBreak(BlockBreakEvent $event) : void {
		$player = $event->getPlayer();
		$block = $event->getBlock();
		if(Factions::isFactionRegion($block)){
			if($player->isGodMode()) return;
			if($block->isSolid()){
				if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
					$event->setCancelled(false);
				}else{
					$player->setMovementTime(time() + 0.1);
					$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
					$event->setCancelled(true);
				}
			}else{
				if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
					$event->setCancelled(false);
				}else{
					$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
					$event->setCancelled(true);
				}
			}
		}
	}

	/**
	 * @param BlockPlaceEvent $event
	 * @return void
	 */
	public function onBlockPlace(BlockPlaceEvent $event) : void {
		$player = $event->getPlayer();
		$block = $event->getBlock();
		if(Factions::isFactionRegion($block)){
			if($player->isGodMode()) return;
			if(Factions::getRegionName($block) === Factions::getFaction($player->getName())){
				$event->setCancelled(false);
			}else{
				$player->sendMessage(str_replace(["&", "{claimName}"], ["§", Factions::getRegionName($block)], Loader::getConfiguration("messages")->get("faction_cannot_interact")));
				$event->setCancelled(true);
			}
		}
	}
    
    /**
     * @param PlayerMoveEvent $event
     * @return void
     */
    public function onPlayerMoveEvent(PlayerMoveEvent $event) : void {
		$player = $event->getPlayer();
		if($player->isMovementTime()){
			$event->setCancelled(true);
		}
    	if($player->getRegion() !== $player->getCurrentRegion()){
    		if($player->getCurrentRegion() === "Spawn"){
    			$player->sendMessage(TE::YELLOW."Now Leaving: ".TE::RED.$player->getRegion().TE::YELLOW." (".TE::RED."Deathban".TE::YELLOW.")");
				$player->sendMessage(TE::YELLOW."Now Entering: ".TE::GREEN."Spawn".TE::YELLOW." (".TE::GREEN."No-Deathban".TE::YELLOW.")");
			}else{ 
				if($player->getRegion() === "Spawn"){
					$player->sendMessage(TE::YELLOW."Now Leaving: ".TE::GREEN."Spawn".TE::YELLOW." (".TE::GREEN."No-Deathban".TE::YELLOW.")");
					$player->sendMessage(TE::YELLOW."Now Entering: ".TE::RED.$player->getCurrentRegion().TE::YELLOW." (".TE::RED."Deathban".TE::YELLOW.")");
				}else{
					$region = $player->getRegion() === Factions::getFaction($player->getName()) ? TE::GREEN.$player->getRegion() : TE::RED.$player->getRegion();
					$currentRegion = $player->getCurrentRegion() === Factions::getFaction($player->getName()) ? TE::GREEN.$player->getCurrentRegion() : TE::RED.$player->getCurrentRegion();
					$player->sendMessage(TE::YELLOW."Now Leaving: ".$region.TE::YELLOW." (".TE::RED."Deathban".TE::YELLOW.")");
					$player->sendMessage(TE::YELLOW."Now Entering: ".TE::RED.$currentRegion.TE::YELLOW." (".TE::RED."Deathban".TE::YELLOW.")");
				}
			}
			$player->setRegion($player->getCurrentRegion());
		}
		if($event->getTo()->getX() !== $event->getFrom()->getX() and $event->getTo()->getZ() != $event->getFrom()->getZ() && $player->isTeleportingHome()){
			$player->setTeleportingHome(false);
			$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
		}
		if($event->getTo()->getX() !== $event->getFrom()->getX() and $event->getTo()->getZ() != $event->getFrom()->getZ() && $player->isTeleportingStuck()){
			$player->setTeleportingStuck(false);
			$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_teleport_time")));
		}
		if($event->getTo()->getX() !== $event->getFrom()->getX() and $event->getTo()->getZ() != $event->getFrom()->getZ() && $player->isLogout()){
			$player->setLogout(false);
			$player->sendMessage(str_replace(["&"], ["§"], Loader::getConfiguration("messages")->get("player_move_in_logout_time")));
		}
		$blockIdAt = $player->getLevel()->getBlockIdAt($player->x, $player->y, $player->z);
		if(in_array($blockIdAt, Loader::getDefaultConfig("block_ids"))){
			$player->changeWorld();
		}
    }
    
    /**
     * @param BlockSpreadEvent $event
     * @return void
	 */
	public function onBlockSpreadEvent(BlockSpreadEvent $event){
		$levelName = $event->getBlock()->getLevel()->getFolderName();
		if(!Loader::getDefaultConfig("SpreadWater")){
			$event->setCancelled(true);
		}else{
			$event->setCancelled(false);
		}
	} 
}

?>