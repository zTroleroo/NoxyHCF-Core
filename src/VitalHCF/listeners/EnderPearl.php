<?php

namespace VitalHCF\listeners;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\utils\{NBT, Time};

use VitalHCF\Task\EnderPearlTask;

use VitalHCF\Task\specials\EggTask;
use VitalHCF\enchantments\CustomEnchantment;

use pocketmine\utils\TextFormat as TE;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\{CompoundTag, ShortTag};

use pocketmine\item\{Item, ItemIds};
use pocketmine\level\{Position, Level};
use pocketmine\block\{Fence, FenceGate};

use pocketmine\event\player\PlayerInteractEvent;

class EnderPearl implements Listener {

    /**
     * EnderPearl Constructor.
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
        $block = $event->getBlock();
        if($item instanceof \VitalHCF\item\FishingRod){
        	if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){
        		$nbt = NBT::createWith($player);
                $entity = Entity::createEntity("FishingHook", $player->getLevel(), $nbt, $player);
                if($entity instanceof \VitalHCF\entities\FishingHook){
                	$entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                    $entity->spawnToAll();
                }
        	}
        }
        if($item instanceof \VitalHCF\item\SplashPotion){
        	if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR||$event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
        		$nbt = NBT::createWith($player);
                $nbt["PotionId"] = new ShortTag("PotionId", $item->getDamage());
                $entity = Entity::createEntity("SplashPotion", $player->getLevel(), $nbt, $player);
                if($entity instanceof \VitalHCF\entities\SplashPotion){
                	$entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                	if($player->isSurvival()){
                		$item->setCount($item->getCount() - 1);
                        $player->getInventory()->setItemInHand(Item::get(Item::AIR));
                    }
                    $entity->spawnToAll();
                }
        	}
        }
        if($item instanceof \VitalHCF\item\EnderPearl && $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){
            if($player->isEnderPearl()){
                $player->sendTip(str_replace(["&", "{time}"], ["§", Time::getTimeToString($player->getEnderPearlTime())], Loader::getConfiguration("messages")->get("enderpearl_cooldown")));
                $event->setCancelled(true);
                return;
            }
            $nbt = NBT::createWith($player);
            $entity = Entity::createEntity("EnderPearl", $player->getLevel(), $nbt, $player);
            if($entity instanceof \VitalHCF\entities\EnderPearl){
                $entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                if($player->isSurvival()){
                    $item->setCount($item->getCount() - 1);
                    $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                }
                $entity->spawnToAll();
                $player->setEnderPearl(true);
                Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new EnderPearlTask($player), 20);
            }
        }
        if($item instanceof \VitalHCF\item\EnderPearl && $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
            if($block instanceof Fence||$block instanceof FenceGate){
                $event->setCancelled(true);
                if($player->isEnderPearl()){
                    $player->sendTip(str_replace(["&", "{time}"], ["§", Time::getTimeToString($player->getEnderPearlTime())], Loader::getConfiguration("messages")->get("enderpearl_cooldown")));
                    $event->setCancelled(true);
                    return;
                }
                $nbt = NBT::createWith($player);
                $entity = Entity::createEntity("EnderPearl", $player->getLevel(), $nbt, $player);
                if($entity instanceof \VitalHCF\entities\EnderPearl){
                    $entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                    if($player->isSurvival()){
                        $item->setCount($item->getCount() - 1);
                        $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                    }
                    $entity->spawnToAll();
                    $player->setEnderPearl(true);
                    Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new EnderPearlTask($player), 20);
                }
            }
        }
        if($item instanceof \VitalHCF\item\specials\EggPorts && $item->getNamedTagEntry(\VitalHCF\item\specials\EggPorts::CUSTOM_ITEM) instanceof CompoundTag && $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){
            if($player->isEgg()){
                $player->sendTip(str_replace(["&", "{time}"], ["§", Time::getTimeToString($player->getEggTime())], Loader::getConfiguration("messages")->get("eggport_cooldown")));
                $event->setCancelled(true);
                return;
            }
            $nbt = NBT::createWith($player);
            $entity = Entity::createEntity("Egg", $player->getLevel(), $nbt, $player);
            if($entity instanceof \VitalHCF\entities\Egg){
                $entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                if($player->isSurvival()){
                    $item->setCount($item->getCount() - 1);
                    $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                }
                $entity->spawnToAll();
                $player->setEgg(true);
                Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new EggTask($player), 20);
            }
        }
        if($item instanceof \VitalHCF\item\specials\EggPorts && $item->getNamedTagEntry(\VitalHCF\item\specials\EggPorts::CUSTOM_ITEM) instanceof CompoundTag && $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
            if($block instanceof Fence||$block instanceof FenceGate){
                $event->setCancelled(true);
                if($player->isEgg()){
                    $player->sendTip(str_replace(["&", "{time}"], ["§", Time::getTimeToString($player->getEggTime())], Loader::getConfiguration("messages")->get("eggport_cooldown")));
                    $event->setCancelled(true);
                    return;
                }
                $nbt = NBT::createWith($player);
                $entity = Entity::createEntity("Egg", $player->getLevel(), $nbt, $player);
                if($entity instanceof \VitalHCF\entities\Egg){
                    $entity->setMotion($entity->getMotion()->multiply($item->getThrowForce()));
                    if($player->isSurvival()){
                        $item->setCount($item->getCount() - 1);
                        $player->getInventory()->setItemInHand($item->getCount() > 0 ? $item : Item::get(Item::AIR));
                    }
                    $entity->spawnToAll();
                    $player->setEgg(true);
                    Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new EggTask($player), 20);
                }
            }
        }
    }
}

?>