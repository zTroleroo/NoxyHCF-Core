<?php

namespace VitalHCF\commands\moderation;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\item\specials\{AntiTrapper,
    NinjaShear,
    SecondChance,
    StormBreaker,
    EggPorts,
    Strength,
    Resistance,
    Invisibility,
    PotionCounter,
    Firework,
    LoggerBait,
    Cactus,
    ZombieBardItem,
    RageBall};

use pocketmine\command\{CommandSender, PluginCommand};
use pocketmine\utils\TextFormat as TE;

class SpecialItemsCommand extends PluginCommand {
	
	/**
	 * SpecialItemsCommand Constructor.
	 */
	public function __construct(){
        parent::__construct("items", Loader::getInstance());
        parent::setDescription("Get all special items from the server");
	}
	
	/**
	 * @param CommandSender $sender
	 * @param String $label
	 * @param Array $args
     * @return void
	 */
	public function execute(CommandSender $sender, String $label, Array $args) : void {
        if(!$sender->isOp()){
			$sender->sendMessage(TE::RED."You have not permissions to use this command");
			return;
        }
        if ($sender instanceof Player) {
            $stormbreaker = new StormBreaker();
            $antitrapper = new AntiTrapper();
            $secondchance = new SecondChance();
            $eggports = new EggPorts();
            $strength = new Strength();
            $resistance = new Resistance();
            $invisibility = new Invisibility();
            $cactus = new Cactus();
            $potionCounter = new PotionCounter();

            $firework = new Firework();
            $loggerbait = new LoggerBait();
            $zombiebarditem = new ZombieBardItem();
            $ninjashear = new NinjaShear();
            $rageball = new RageBall();

            $sender->getInventory()->addItem($ninjashear);
            $sender->getInventory()->addItem($stormbreaker);
            $sender->getInventory()->addItem($antitrapper);
            $sender->getInventory()->addItem($rageball);
            $sender->getInventory()->addItem($zombiebarditem);
            $sender->getInventory()->addItem($loggerbait);
            $sender->getInventory()->addItem($eggports);
            $sender->getInventory()->addItem($strength);
            $sender->getInventory()->addItem($resistance);
            $sender->getInventory()->addItem($invisibility);
            $sender->getInventory()->addItem($cactus);
            $sender->getInventory()->addItem($potionCounter);
            $sender->getInventory()->addItem($firework);
            $sender->getInventory()->addItem($secondchance);
        }
	}
}

?>