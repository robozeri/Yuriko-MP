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
use pocketmine\block\Block;
use pocketmine\utils\TextFormat;

class SetblockCommand extends VanillaCommands{


	public function __construct($name){
		parent::__construct(
			$name,
			"Changes a block to another block.",
			"/setblock <x> <y> <z> <TileName>"
		);
		$this->setPermission("pocketmine.command.setblock");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(!($sender instanceof Player)){
			$sender->sendMessage("Please use this command in-game");
		}

		if(!isset($args[0]) or !isset($args[1]) or !isset($args[2]) or !isset($args[3])){
			$sender->sendMessage("Missing arguments");
		}

		// TODO: Setblock mechanics (need help)
	}
			
}