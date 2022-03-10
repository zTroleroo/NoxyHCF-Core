<?php

namespace VitalHCF;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use VitalHCF\provider\{
    SQLite3Provider, YamlProvider, MysqlProvider,
};
use VItalHCF\player\{
    Player,
};
use VitalHCF\API\{
    Scoreboards,
};
use VitalHCF\Task\{
	BardTask, ArcherTask, MageTask, GhostTask, 
};
use VitalHCF\Task\event\{
	FactionTask,
};
use VitalHCF\block\{
    Blocks,
};
use VitalHCF\listeners\{
	Listeners,
};
use VitalHCF\commands\{
    Commands,
};
use VitalHCF\item\{
    Items,
};
use VitalHCF\entities\{
    Entitys,
};
use VitalHCF\enchantments\{
    Enchantments,
};
use VitalHCF\utils\{Data, Extensions};
use libs\muqsit\invmenu\InvMenuHandler;

class Loader extends PluginBase {
    
    /** @var Loader */
    protected static $instance;
    
    /** @var Array[] */
    public static $appleenchanted = [], $rogue = [];
    
    /** @var Array[] */
	public $permission = [];
    
    /**
     * @return void
     */
    public function onLoad() : void {
        self::$instance = $this;
    }
    
    /**
     * @return void
     */
    public function onEnable(): void
    {
        
        MysqlProvider::connect();
        SQLite3Provider::connect();

        Listeners::init();
        Commands::init();
        Items::init();
        Blocks::init();
        Entitys::init();
        Enchantments::init();
        
        YamlProvider::init();
        
        Factions::init();
        InvMenuHandler::register($this);

        $this->getScheduler()->scheduleRepeatingTask(new BardTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new GhostTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new ArcherTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new MageTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new FactionTask(), 5 * 60 * 40);
    }
    
    /**
     * @return void
     */
    public function onDisable() : void {
        SQLite3Provider::disconnect();
        MysqlProvider::disconnect();

        YamlProvider::save();
    }

    /**
     * @return Loader
     */
    public static function getInstance() : Loader {
        return self::$instance;
    }

    /**
     * @return SQLite3Provider
     */
    public static function getProvider() : SQLite3Provider {
        return new SQLite3Provider();
    }

    /**
     * @return Scoreboards
     */
	public static function getScoreboard() : Scoreboards {
		return new Scoreboards();
    }

    /**
     * @param String $configuration
     */
    public static function getDefaultConfig($configuration){
        return self::getInstance()->getConfig()->get($configuration);
    }
    
    /**
     * @param String $configuration
     */
    public static function getConfiguration($configuration){
    	return new Config(self::getInstance()->getDataFolder()."{$configuration}.yml", Config::YAML);
    }

    /**
     * @param Player $player
     */
    public function getPermission(Player $player){
        if(!isset($this->permission[$player->getName()])){
            $this->permission[$player->getName()] = $player->addAttachment($this);
        }
        return $this->permission[$player->getName()];
    }
}

?>