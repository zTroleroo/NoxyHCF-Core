<?php

namespace VitalHCF\commands;

use VitalHCF\Loader;
use VitalHCF\player\{Player, PlayerBase};

use VitalHCF\crate\CrateManager;
use VitalHCF\utils\Time;

use pocketmine\item\{Item, ItemIds};
use pocketmine\utils\TextFormat as TE;
use pocketmine\command\{CommandSender, PluginCommand};

class ReclaimCommand extends PluginCommand {
	
	/**
	 * ReclaimCommand Constructor.
	 */
	public function __construct(){
		parent::__construct("claim", Loader::getInstance());
		
		parent::setDescription("Claim your daily rewards");
	}
	
	/**
	 * @param CommandSender $sender
	 * @param String $label
	 * @param Array $args
	 * @return void
	 */
	public function execute(CommandSender $sender, String $label, Array $args) : void {
		if($sender->getRank() === "Owner"||$sender->getRank() === "Co-Owner"||$sender->getRank() === "Developer"||$sender->getRank() === "Admin"||$sender->getRank() === "Sr-Admin"||$sender->getRank() === "Jr-Admin"||$sender->getRank() === "Sr-Mod"||$sender->getRank() === "Mod"){
        	if($sender->getTimeReclaimRemaining() < time()){
        		try {
	        		$sender->resetReclaimTime();
	
					if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(60);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 30);
					CrateManager::giveKey($sender, "Infernal", 25);
					CrateManager::giveKey($sender, "Hell", 20);
					CrateManager::giveKey($sender, "Ability", 20);
    
CrateManager::giveKey($sender, "Partner", 10);
                    
CrateManager::giveKey($sender, "Horny", 20);
                    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("staff_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
            	$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
			}
		}
		if($sender->getRank() === "Partner"||$sender->getRank() === "Mild"){
			if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
            		if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(50);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 25);
					CrateManager::giveKey($sender, "Infernal", 25);
					CrateManager::giveKey($sender, "Hell", 15);
                   
CrateManager::giveKey($sender, "Horny", 15);
					CrateManager::giveKey($sender, "Ability", 15);
                    
CrateManager::giveKey($sender, "Partner", 10);
 

					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("partner_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
		}
		if($sender->getRank() === "Infernal"){
			if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(30);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 30);
					CrateManager::giveKey($sender, "Infernal", 25);
					CrateManager::giveKey($sender, "Hell", 16);
                    
CrateManager::giveKey($sender, "Horny", 15);
					CrateManager::giveKey($sender, "Ability", 15);
                    
CrateManager::giveKey($sender, "Partner", 10);  
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("infernal_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
		if($sender->getRank() === "Ember"){
			if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(20);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 28);
					CrateManager::giveKey($sender, "Infernal", 22);
					CrateManager::giveKey($sender, "Hell", 14);
                    
CrateManager::giveKey($sender, "Horny", 14);
					CrateManager::giveKey($sender, "Ability", 10);
    
CrateManager::giveKey($sender, "Partner", 8);
                    Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("ember_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
        if($sender->getRank() === "Demon"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(8);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 14);
					CrateManager::giveKey($sender, "Infernal", 10);
					CrateManager::giveKey($sender, "Hell", 6);
                    
CrateManager::giveKey($sender, "Horny", 6);
					CrateManager::giveKey($sender, "Ability", 2);
    
CrateManager::giveKey($sender, "Partner", 4);
                    Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("demon_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
		}
		if($sender->getRank() === "Averno"){
			if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(10);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 20);
					CrateManager::giveKey($sender, "Infernal", 15);
					CrateManager::giveKey($sender, "Hell", 8);
                    
CrateManager::giveKey($sender, "Horny", 8);
					CrateManager::giveKey($sender, "Ability", 6);

CrateManager::giveKey($sender, "Partner", 6);                    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("averno_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
		}
				if($sender->getRank() === "NitroBooster"){
			if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(10);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 20);
					CrateManager::giveKey($sender, "Infernal", 15);
					CrateManager::giveKey($sender, "Hell", 8);
                    
CrateManager::giveKey($sender, "Horny", 8);
					CrateManager::giveKey($sender, "Ability", 6);

CrateManager::giveKey($sender, "Partner", 6);                    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("nitro_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
		}
        if($sender->getRank() === "YouTuber"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(6);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 20);
					CrateManager::giveKey($sender, "Infernal", 15);
					CrateManager::giveKey($sender, "Hell", 10);
                    
CrateManager::giveKey($sender, "Horny", 10);
					CrateManager::giveKey($sender, "Ability", 8);
    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("youtuber_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
        if($sender->getRank() === "Famous"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(8);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 25);
					CrateManager::giveKey($sender, "Infernal", 20);
					CrateManager::giveKey($sender, "Hell", 15);
                    
CrateManager::giveKey($sender, "Horny", 15);
					CrateManager::giveKey($sender, "Ability", 8);
    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("famous_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
        if($sender->getRank() === "Soul"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(5);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 10);
					CrateManager::giveKey($sender, "Infernal", 8);
					CrateManager::giveKey($sender, "Hell", 4);
                    
CrateManager::giveKey($sender, "Horny", 4);
    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("soul_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
                if($sender->getRank() === "MiniYT"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(5);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 10);
					CrateManager::giveKey($sender, "Infernal", 8);
					CrateManager::giveKey($sender, "Hell", 4);
                    
CrateManager::giveKey($sender, "Horny", 4);
    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("miniyt_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
        if($sender->getRank() === "Guest"){
        	if($sender->getTimeReclaimRemaining() < time()){
				try {
					$sender->resetReclaimTime();
                
        			if(!PlayerBase::getData($sender->getName())->get("lives_claimed")) $sender->setLives(5);
					PlayerBase::setData($sender->getName(), "lives_claimed", true);
					
					CrateManager::giveKey($sender, "Poison", 10);
					CrateManager::giveKey($sender, "Infernal", 6);
					CrateManager::giveKey($sender, "Hell", 2);
                    
CrateManager::giveKey($sender, "Horny", 2);
    
					Loader::getInstance()->getServer()->broadcastMessage(str_replace(["&", "{playerName}", "{rank}"], ["§", $sender->getName(), $sender->getRank()], Loader::getConfiguration("messages")->get("guest_reclaim_correctly")));
				} catch(\Exception $exception){
					$sender->sendMessage($exception->getMessage());
				}
            }else{
				$sender->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($sender->getTimeReclaimRemaining())], Loader::getConfiguration("messages")->get("function_cooldown")));
            }
        }
    }
}

?>