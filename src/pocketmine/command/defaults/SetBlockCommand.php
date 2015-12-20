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
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\block\Block;

class SetBlockCommand extends VanillaCommand{

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
			$sender->sendMessage("Please run this command in-game");

			return false;
		}

		if(count($args) !== 4){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		$block = Item::fromString($args[3]);

		if($block instanceof ItemBlock and $block->getBlock() instanceof Block){
			$block = $block->getBlock();
		}else{
			$sender->sendMessage("Invalid Block ID");

			return false;
		}

		for($i = 0; $i <= 2; $i++){
			if($args[$i] === chr(126)){ //Tilde
				if($i === 0){
					$args[$i] = $sender->x;
				}elseif($i === 1){
					$args[$i] = $sender->y;
				}elseif($i === 2){
					$args[$i] = $sender->z;
				}
			}
		}

		if(!is_numeric($args[0]) or !is_numeric($args[1]) or !is_numeric($args[2])){
			$sender->sendMessage("Please use numeric values for coordinates arguments");

			return false;
		}

		if($sender->level->setBlock(new Vector3((int) $args[0], (int) $args[1], (int) $args[2]), $block)){
			$sender->sendMessage("Block ".$block->getName()." placed at x=".$args[0].", y=".$args[1].", z=".$args[2]);

			return true;
		}

		$sender->sendMessage("Failed placing block due to unknown error");

		return false;
	}
}