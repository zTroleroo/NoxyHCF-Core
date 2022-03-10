<?php

namespace VitalHCF\listeners\interact;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\Player;

use VitalHCF\utils\Translator;

use pocketmine\entity\{Effect, EffectInstance};
use pocketmine\event\Listener;
use pocketmine\item\{Item, ItemIds};

use pocketmine\event\player\{PlayerInteractEvent};
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};

class Ghost implements Listener {
	
	/** @var Loader */
	protected $plugin;
	
	/**
	 * Ghost Constructor.
	 */
	public function __construct(){
		
	}
	
	/**
     * @param PlayerInteractEvent $event
     * @return void
     */
	public function onPlayerInteractEvent(PlayerInteractEvent $event) : void {
		$player = $event->getPlayer();
		$item = $event->getItem();
		if($player->isGhostClass()){
			if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR||$event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
				switch($item->getId()){
					case ItemIds::SUGAR:
						if(Factions::isSpawnRegion($player)){
							$event->setCancelled(true);
							return;
						}
						if($player->getGhostEnergy() < $player->getGhostEnergyCost($item->getId())){
							$player->sendMessage(str_replace(["&", "{currentEnergy}", "{needEnergy}"], ["§", $player->getGhostEnergy(), $player->getGhostEnergyCost($item->getId())], Loader::getConfiguration("messages")->get("ninja_not_enough_energy")));
							return;
						}
						$effect = new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 5, 4);

						$player->setGhostEnergy($player->getGhostEnergy() - $player->getGhostEnergyCost($item->getId()));
						$player->addEffect($effect);
                        $player->sendMessage(str_replace(["&", "{effectName}", "{effectLevel}"], ["§", Translator::effectToStringByObject($effect), $effect->getAmplifier()], Loader::getConfiguration("messages")->get("ninja_give_effects")));


                        $item->setCount($item->getCount() - 1);
                        $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        if(Factions::inFaction($player->getName())){
                        	foreach(Factions::getPlayers(Factions::getFaction($player->getName())) as $value){
                           	 $online = Loader::getInstance()->getServer()->getPlayer($value);
                        	    if($online instanceof Player && $online->distanceSquared($player) < 250){
                           	     	$online->addEffect($effect);
                           	    	$online->sendMessage(str_replace(["&", "{playerName}", "{effectName}", "{effectLevel}"], ["§", $player->getName(), Translator::effectToStringByObject($effect), $effect->getAmplifier()], Loader::getConfiguration("messages")->get("ninja_global_give_effects")));
                            	}
                            }
                        }
					break;
					case ItemIds::IRON_NUGGET:
						if(Factions::isSpawnRegion($player)){
							$event->setCancelled(true);
							return;
						}
						if($player->getGhostEnergy() < $player->getGhostEnergyCost($item->getId())){
							$player->sendMessage(str_replace(["&", "{currentEnergy}", "{needEnergy}"], ["§", $player->getBardEnergy(), $player->getGhostEnergyCost($item->getId())], Loader::getConfiguration("messages")->get("ninja_not_enough_energy")));
							return;
						}
						$effect = new EffectInstance(Effect::getEffect(Effect::REGENERATION), 20 * 10, 4);
						$effect = new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 10, 1);
						
						$player->setGhostEnergy($player->getGhostEnergy() - $player->getGhostEnergyCost($item->getId()));
						$player->addEffect($effect);
						$player->sendMessage(str_replace(["&", "{effectName}", "{effectLevel}"], ["§", Translator::effectToStringByObject($effect), $effect->getAmplifier()], Loader::getConfiguration("messages")->get("ninja_give_effects")));

						$item->setCount($item->getCount() - 1);
                        $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                        
					break;
                }
			}
		}
	}
}

?>