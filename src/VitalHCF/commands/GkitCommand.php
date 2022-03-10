<?php

namespace VitalHCF\commands;

use VitalHCF\Loader;
use VitalHCF\kit\KitManager;

use VitalHCF\utils\Time;

use VitalHCF\FormAPI\{FormData, MenuForm};

use pocketmine\Player;
use pocketmine\item\ItemFactory;
use pocketmine\utils\TextFormat as TE;
use pocketmine\command\{CommandSender, PluginCommand};

class GkitCommand extends PluginCommand {
	
	/**
	 * GkitCommand Constructor.
	 */
	public function __construct(){
		parent::__construct("gkit", Loader::getInstance());
		
		parent::setDescription("Can see the selection of kits on the server");
	}
	
	/**
	 * @param CommandSender $sender
	 * @param String $label
	 * @param Array $args
	 * @return void
	 */
	public function execute(CommandSender $sender, String $label, Array $args) : void {
		$this->open($sender);
	}
	
	/**
	 * @param Player $player
	 * @return Form
	 */
	protected function open(Player $player){
		$form = new MenuForm(function (Player $player, $data){
			if($data === null){
				return;
			}
			$kitManager = KitManager::getKit($data);
			if(!$player->hasPermission($kitManager->getPermission())){
				$player->sendMessage(TE::RED."You have not permissions to use this kit!");
				return;
			}
			if($player->isGodMode()){
				foreach($kitManager->getItems() as $slot => $item){
					if(!$player->getInventory()->canAddItem(ItemFactory::get($item->getId(), $item->getDamage()))){
						$player->dropItem($item, true);
					}else{
						$player->getInventory()->addItem($item);
						$player->getArmorInventory()->setContents($kitManager->getArmorItems());
					}
				}
			}elseif($player->getTimeKitRemaining($kitManager->getName()) < time()){
				foreach($kitManager->getItems() as $slot => $item){
					if(!$player->getInventory()->canAddItem(ItemFactory::get($item->getId(), $item->getDamage()))){
						$player->resetKitTime($kitManager->getName());
						$player->dropItem($item, true);
					}else{
						$player->resetKitTime($kitManager->getName());
						$player->getInventory()->addItem($item);
						$player->getArmorInventory()->setContents($kitManager->getArmorItems());
					}
				}
			}else{
				$player->sendMessage(str_replace(["&", "{time}"], ["§", Time::getTime($player->getTimeKitRemaining($kitManager->getName()))], Loader::getConfiguration("messages")->get("function_cooldown")));
			}
		});
		$form->setTitle(TE::GOLD.TE::BOLD."KIT SELECTOR!");
		foreach(KitManager::getKits() as $kit){
			$form->addButton($kit->getNameFormat().TE::RESET."\n".TE::DARK_GRAY."Click to get!", -1, "", $kit->getName());
		}
		$player->sendForm($form);
		return $form;
	}
}

?>