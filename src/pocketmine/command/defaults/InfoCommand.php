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
use pocketmine\event\TranslationContainer;
use pocketmine\Player;


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

		foreach($sender->getServer()->getOnlinePlayers() as $players){
			$pn = $players->getName();
		}

		if($sender instanceof Player){
			if($args[0] == null){
				$player = $sender;

				$msg = 
					$player->getName() . "\n" . 
					"GM: " . $player->getGamemode() . 
					" HP: " . $player->getHealth() . "/" . $player->getMaxHealth() . 
					" LVL: " . $player->getExpLevel() . "\n" . 

					"  X: " . $player->getX() . 
					" Y: " . $player->getY() . 
					" Z: " . $player->getZ() . 
					"in: " . $player->getLevel()->getName();

				$sender->sendMessage($msg);
			}else{
				if($args[0] == strtolower($pn)){
					$player = $players;
					$msg = 
						$player->getName() . "\n" . 
						"GM: " . $player->getGamemode() . 
						" HP: " . $player->getHealth() . "/" . $player->getMaxHealth() . 
						" LVL: " . $player->getExpLevel() . "\n" . 

						"  X: " . $player->getX() . 
						" Y: " . $player->getY() . 
						" Z: " . $player->getZ() . 
						"in: " . $player->getLevel()->getName();

					$sender->sendMessage($msg);
				}
			}
		}else{
			if($args[0] == strtolower($pn)){
				$player = $players;
				$msg = 
					$player->getName() . "\n" . 
					"GM: " . $player->getGamemode() . 
					" HP: " . $player->getHealth() . "/" . $player->getMaxHealth() . 
					" LVL: " . $player->getExpLevels() . "\n" . 

					"  X: " . $player->getX() . 
				" Y: " . $player->getY() . 
				" Z: " . $player->getZ() . 
				" in: " . $player->getLevel()->getName();

				$sender->sendMessage($msg);
			}elseif($args[0] == null){
				$sender->sendMessage("You must specify a player!");
			}
		}

		return true;
	}
}