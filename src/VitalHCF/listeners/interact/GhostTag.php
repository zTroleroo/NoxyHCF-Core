<?php

namespace VitalHCF\listeners\interact;

use VitalHCF\{Loader, Factions};
use VitalHCF\player\Player;

use VitalHCF\utils\Translator;

use VitalHCF\Task\GhostTagTask;

use pocketmine\utils\TextFormat as TE;
use pocketmine\event\Listener;
use pocketmine\entity\projectile\Arrow;

use pocketmine\item\{Item, ItemIds};
use pocketmine\entity\{Effect, EffectInstance};

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\{ProjectileHitEvent, ProjectileHitEntityEvent, EntityDamageEvent, EntityDamageByEntityEvent};

class GhostTag implements Listener {
	
	/**
	 * Archer Constructor.
	 */
	public function __construct(){

    }
    
    /**
     * @param ProjectileHitEvent $event
     * @return void
     */
    public function onProjectileHitEvent(ProjectileHitEvent $event) : void {
        $entity = $event->getEntity();
        if($entity instanceof Arrow){
            $damager = $entity->getOwningEntity();
            if($damager instanceof Player && $event instanceof ProjectileHitEntityEvent && $damager->isGhostClass()){
                $player = $event->getEntityHit();
                if($player instanceof Player && !Factions::isSpawnRegion($damager) && !Factions::isSpawnRegion($player)){
                    if($player->isGhostTag()){
                    	$player->setGhostTag(false);
                    }
                    if($player->getName() === $damager->getName()) return;

                    if(Factions::inFaction($damager->getName()) && Factions::inFaction($player->getName()) && Factions::getFaction($damager->getName()) === Factions::getFaction($player->getName())) return;

                    $damager->sendMessage(str_replace(["&", "{playerName}", "{playerHealth}"], ["§", $player->getName(), $player->getHealth()], Loader::getConfiguration("messages")->get("ninja_tag_mark_target")));
                    $player->setGhostTag(true);
                    Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new GhostTagTask($player), 20);
                }
            }
        }
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     */
    public function onEntityDamageEvent(EntityDamageEvent $event) : void {
        $player = $event->getEntity();
        if($event instanceof EntityDamageByEntityEvent && !$event->isCancelled()){
            $damager = $event->getDamager();
            if($player instanceof Player and $damager instanceof Player){
                if($player->isGhostTag()){
                    $baseDamage = $event->getBaseDamage();
                    $event->setBaseDamage($baseDamage + 2.0);
                }
            }
        }
    }
}
?>