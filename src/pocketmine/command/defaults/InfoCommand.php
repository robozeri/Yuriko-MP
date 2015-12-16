<?php

/*
 *
 * __   __          _ _               __  __ ____  
 * \ \ / /   _ _ __(_) | _____       |  \/  |  _ \ 
 *  \ V / | | | '__| | |/ / _ \ _____| |\/| | |_) |
 *   | || |_| | |  | |   < (_) |_____| |  | |  __/ 
 *   |_| \__,_|_|  |_|_|\_\___/      |_|  |_|_|
 *
 * Yuriko-MP, a kawaii-powered PocketMine-based software
 * for Minecraft: Pocket Edition
 * Copyright 2015 ItalianDevs4PM.
 *
 * This work is licensed under the Creative Commons
 * Attribution-NonCommercial-NoDerivatives 4.0
 * International License.
 * 
 *
 * @author ItalianDevs4PM
 * @link   http://github.com/ItalianDevs4PM
 *
 *
 */

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class InfoCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"Gives information about a player",
			"/info [player]"
		);
		$this->setPermission("pocketmine.command.info");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(!isset($args[0]) and !($sender instanceof  Player)){
			return false;
		}

		if(!isset($args[0])){
			$sender->sendMessage(
				$sender->getName() . "\n" .
				"GM: " . $sender->getGamemode() .
				" HP: " . $sender->getHealth() . "/" . $sender->getMaxHealth() .
				/*" LVL: " . $sender->getExpLevel() .*/ "\n" .
				" X: " . $sender->getX() .
				" Y: " . $sender->getY() .
				" Z: " . $sender->getZ() .
				" in: " . $sender->getLevel()->getName());
			return true;
		}

		if(($player = $sender->getServer()->getPlayer($args[0])) !== null){
			$sender->sendMessage(
				$player->getName() . "\n" .
				"GM: " . $player->getGamemode() .
				" HP: " . $player->getHealth() . "/" . $player->getMaxHealth() .
				/*" LVL: " . $sender->getExpLevel() .*/ "\n" .
				" X: " . $player->getX() .
				" Y: " . $player->getY() .
				" Z: " . $player->getZ() .
				" in: " . $player->getLevel()->getName());
			return true;
		}

		$sender->sendMessage(TextFormat::RED . "Can't find player " . $args[0]);

		return true;
	}
}