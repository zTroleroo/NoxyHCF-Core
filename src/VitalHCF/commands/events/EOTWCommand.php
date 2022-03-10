<?php

namespace VitalHCF\commands\events;

use VitalHCF\Loader;
use VitalHCF\player\Player;

use VitalHCF\utils\Translator;

use VitalHCF\listeners\event\EOTW;

use pocketmine\command\{CommandSender, PluginCommand};
use pocketmine\utils\TextFormat as TE;

class EOTWCommand extends PluginCommand {
	
	/**
	 * EOTWCommand Constructor.
	 */
	public function __construct(){
		parent::__construct("eotw", Loader::getInstance());
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
		if(empty($args)){
			$sender->sendMessage(TE::RED."Argument #1 is not valid for command syntax");
			return;
		}
		switch($args[0]){
			case "on":
				if(!$sender->isOp()){
					$sender->sendMessage(TE::RED."You have not permissions to use this command");
					return;
				}
				if(empty($args[1])){
					$sender->sendMessage(TE::RED."Use: /{$label} {$args[0]} [Int: time]");
					return;
				}
				if(EOTW::isEnable()){
					$sender->sendMessage(TE::RED."The event was started before, you can't do this!");
					return;
				}
				if(!in_array(Translator::intToString($args[1]), Translator::VALID_FORMATS)){
					$sender->sendMessage(TE::RED."The time format you enter is invalid!");
					return;
				}
				EOTW::start(Translator::getStringFormatToInt(Translator::stringToInt($args[1]), $args[1]) ?? 60);
			break;
			case "off":
				if(!$sender->isOp()){
					$sender->sendMessage(TE::RED."You have not permissions to use this command");
					return;
				}
				if(!EOTW::isEnable()){
					$sender->sendMessage(TE::RED."The event was never started, you can't do this!");
					return;
				}
				EOTW::stop();
			break;
			case "help":
			case "?":
				if(!$sender->isOp()){
					$sender->sendMessage(TE::RED."You have not permissions to use this command");
					return;
				}
				$sender->sendMessage(
					TE::YELLOW."/{$label} on [int: time] ".TE::GRAY."(To turn on the EOTW Timer counter)"."\n".
					TE::YELLOW."/{$label} off ".TE::GRAY."(To turn off the EOTW Timer)"
				);
			break;
		}
	}
}

?>