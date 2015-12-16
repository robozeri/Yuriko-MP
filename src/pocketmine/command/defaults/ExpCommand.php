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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ExpCommand extends VanillaCommand{

	public function __construct($name){ // TO TRANSLATE
		parent::__construct($name,
		"Gives the specified player a certain amount of experience. Specify <amount>L to give levels instead, with a negative amount resulting in taking levels.",
		"/xp <amount> [player] OR /xp <amount>L [player]", []);
		$this->setPermission("pocketmine.command.xp");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		
		if(count($args) > 0){ // TO TRANSLATE
			$inputAmount = $args[0];
			$player = null;
			
			$isLevel = $this->endsWith($inputAmount, "l") || $this->endsWith($inputAmount, "L");
			if($isLevel && strlen($inputAmount) > 1){
				$inputAmount = substr($inputAmount, 0, strlen($inputAmount) - 1);
			}
			
			$amount = intval($inputAmount);
			$isTaking = $amount < 0;
			
			if($isTaking){
				$amount *= -1;
			}
			
			if(count($args) > 1){
				$player = $sender->getServer()->getPlayer($args[1]);
			}
			elseif($sender instanceof Player){
				$player = $sender;
			}
			
			if($player != null){
				if($isLevel){
					if($isTaking){
						$player->removeExpLevels($amount);
						$player->getServer()->broadcastMessage("Taken " . $amount + " level(s) from " . $player->getName(), $player);
					}
					else{
						$player->giveExpLevels($amount);
						$player->getServer()->broadcastMessage("Given " . $amount + " level(s) to " . $player->getName(), $sender);
					}
				}
				else{
					if($isTaking){
						$sender->sendMessage(TextFormat::RED . "Taking experience can only be done by levels, cannot give players negative experience points");
						return false;
					}
					else{
						$player->giveExp($amount);
						$player->getServer()->broadcastMessage("Given " . $amount + " experience to " . $player->getName(), $sender);
					}
				}
			}
			else{
				$sender->sendMessage("Can't find player, was one provided?\n" . TextFormat::RED . "Usage: " . $this->usageMessage);
				return false;
			}
			
			return true;
		}
		
		$sender->sendMessage(TextFormat::RED . "Usage: " . $this->usageMessage);
		return false;
	}
	
	//$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
	//Command::broadcastCommandMessage($sender, new TranslationContainer("%commands.give.success", [$xp->getName() . " (" . $xp->getId() . ":" . $xp->getDamage() . ")",(string) $xp->getCount(),$player->getName()]));
	public function endsWith($haystack, $needle){
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
}
