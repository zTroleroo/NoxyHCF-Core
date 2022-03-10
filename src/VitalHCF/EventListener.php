<?php

namespace VitalHCF;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\{Player, PlayerBase};
use VitalHCF\crate\CrateManger;

use VitalHCF\Task\asynctask\{LoadPlayerData, SavePlayerData};

use VitalHCF\Task\Scoreboard;

use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as TE;
use pocketmine\level\biome\Biome;

use pocketmine\event\level\ChunkLoadEvent;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent, PlayerChatEvent, PlayerMoveEvent, PlayerInteractEvent};
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

class EventListener implements Listener {

    /**
     * EventListener Constructor.
     */
    public function __construct(){
		
    }
    
    /**
     * @param PlayerCreationEvent $event
     * @return void
     */
    public function onPlayerCreationEvent(PlayerCreationEvent $event) : void {
        $event->setPlayerClass(Player::class, true);
    }

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function onPlayerJoinEvent(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $event->setJoinMessage(TE::GRAY."[".TE::GREEN."+".TE::GRAY."] ".TE::GREEN.$player->getName().TE::GRAY." entered the server!");
        
        
        PlayerBase::create($player->getName());
		Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new Scoreboard($player), 20);
        Loader::getInstance()->getServer()->getAsyncPool()->submitTask(new LoadPlayerData($player->getName(), $player->getUniqueId()->toString(), Loader::getDefaultConfig("MySQL")["hostname"], Loader::getDefaultConfig("MySQL")["username"], Loader::getDefaultConfig("MySQL")["password"], Loader::getDefaultConfig("MySQL")["database"], Loader::getDefaultConfig("MySQL")["port"]));
    }

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onPlayerQuitEvent(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
		$event->setQuitMessage(TE::GRAY."[".TE::RED."-".TE::GRAY."] ".TE:: RED.$player->getName().TE::GRAY." left the server!");

        Loader::getInstance()->getServer()->getAsyncPool()->submitTask(new SavePlayerData($player->getAddress(), Factions::inFaction($player->getName()) ? Factions::getFaction($player->getName()) : "This player not have faction", Loader::getDefaultConfig("MySQL")["hostname"], Loader::getDefaultConfig("MySQL")["username"], Loader::getDefaultConfig("MySQL")["password"], Loader::getDefaultConfig("MySQL")["database"], Loader::getDefaultConfig("MySQL")["port"]));         if($player instanceof Player){             $player->removePermissionsPlayer();
		}
	}
	
	/**
     * @param EntityLevelChangeEvent $event
     * @return void
     */
	public function onEntityLevelChangeEvent(EntityLevelChangeEvent $event) : void {
		$player = $event->getEntity();
		$player->showCoordinates();
	}
    
    /**
     * @param PlayerChatEvent $event
     * @return void
     */
    public function onPlayerChatEvent(PlayerChatEvent $event) : void {
    	$player = $event->getPlayer();
    	$format = null;
    	if($player->getRank() === null||$player->getRank() === "Guest"){
    		$format = TE::WHITE.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Owner"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE.TE::OBFUSCATED."!!".TE::RESET.TE::BLACK."COOL".TE::LIGHT_PURPLE.TE::OBFUSCATED."!!".TE::RESET.TE::DARK_GRAY."]".TE::DARK_GRAY."[".TE::RED."Owner".TE::DARK_GRAY."] ".TE::DARK_RED.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Co-Owner"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE.TE::OBFUSCATED."!!".TE::RESET.TE::BLACK."LOL".TE::LIGHT_PURPLE.TE::OBFUSCATED."!!".TE::RESET.TE::DARK_GRAY."]".TE::DARK_GRAY."[".TE::RED."Co-Owner".TE::DARK_GRAY."] ".TE::RED.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Admin"){
    		$format = TE::DARK_GRAY."[".TE::GREEN."Admin".TE::DARK_GRAY."] ".TE::GREEN.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Sr-Mod"){
    		$format = TE::DARK_GRAY."[".TE::DARK_PURPLE."Sr-Mod".TE::DARK_GRAY."] ".TE::DARK_PURPLE.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Mod"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE."Mod".TE::DARK_GRAY."] ".TE::LIGHT_PURPLE.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Jr-Admin"){
    		$format = TE::DARK_GRAY."[".TE::DARK_GREEN."Jr-Admin".TE::DARK_GRAY."] ".TE::DARK_GREEN.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Sr-Admin"){
    		$format = TE::DARK_GRAY."[".TE::AQUA."Sr-Admin".TE::DARK_GRAY."] ".TE::AQUA.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "T-Mod"){
    		$format = TE::DARK_GRAY."[".TE::DARK_AQUA."Trial-Mod".TE::DARK_GRAY."] ".TE::DARK_AQUA.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Trainee"){
    		$format = TE::DARK_GRAY."[".TE::YELLOW."Trainee".TE::DARK_GRAY."] ".TE::YELLOW.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Developer"){
    		$format = TE::DARK_GRAY."[".TE::BOLD.TE::BLACK."666".TE::RESET.TE::DARK_GRAY."]".TE::DARK_GRAY."[".TE::YELLOW."Developer".TE::DARK_GRAY."] ".TE::YELLOW.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Demon"){
    		$format = TE::DARK_GRAY."[".TE::RED."Demon".TE::DARK_GRAY."] ".TE::RED.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Averno"){
    		$format = TE::DARK_GRAY."[".TE::YELLOW."Averno".TE::DARK_GRAY."] ".TE::YELLOW.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Ember"){
    		$format = TE::DARK_GRAY."[".TE::DARK_RED.TE::BOLD."Ember".TE::RESET.TE::DARK_GRAY."] ".TE::DARK_RED.$player->getName().TE::WHITE;
		}
		if($player->getRank() === "System"){
    		$format = TE::DARK_GRAY."[".TE::BOLD.TE::AQUA."System".TE::RESET.TE::DARK_GRAY."] ".TE::GOLD.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "NitroBooster"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE."NitroBooster".TE::RESET.TE::DARK_GRAY."] ".TE::LIGHT_PURPLE.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Soul"){
    		$format = TE::DARK_GRAY."[".TE::DARK_GREEN."Soul".TE::GRAY."] ".TE::DARK_GREEN.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Partner"){
    		$format = TE::DARK_GRAY."[".TE::OBFUSCATED.TE::YELLOW."!!".TE::RESET.TE::AQUA.TE::BOLD."Partner".TE::RESET.TE::OBFUSCATED.TE::YELLOW."!!".TE::RESET.TE::DARK_GRAY."] ".TE::AQUA.$player->getName().TE::WHITE;
    	}
        if($player->getRank() === "Mild"){

    		$format = TE::DARK_GRAY."[".TE::AQUA.TE::BOLD."CRACKS".TE::RESET.TE::DARK_GRAY."]".TE::WHITE."[".TE::GRAY.TE::BOLD."Partner".TE::RESET.TE::WHITE."] ".TE::BLACK.$player->getName().TE::GRAY;
    	}
    	if($player->getRank() === "MiniYT"){
    		$format = TE::DARK_GRAY."[".TE::RED."Mini".TE::WHITE."YT".TE::DARK_GRAY."] ".TE::RED.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "YouTuber"){
    		$format = TE::DARK_GRAY."[".TE::DARK_RED."You".TE:: DARK_RED."Tuber".TE::DARK_GRAY."] ".TE::DARK_RED.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Famous"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE.TE::BOLD."Famous".TE::RESET.TE::DARK_GRAY."] ".TE::LIGHT_PURPLE.$player->getName().TE::WHITE;
    	}
    	if($player->getRank() === "Twitch"){
    		$format = TE::DARK_GRAY."[".TE::LIGHT_PURPLE."Twitch".TE::DARK_GRAY."] ".TE::LIGHT_PURPLE.$player->getName().TE::WHITE;
    	}
    	if(Factions::inFaction($player->getName())){
			$factionName = Factions::getFaction($player->getName());
			$event->setFormat(TE::GOLD."[".TE::RED.$factionName.TE::GOLD."]".TE::RESET.$format.": ".$event->getMessage());
		}else{
			$event->setFormat($format.": ".$event->getMessage());
		}
	}
}

?>