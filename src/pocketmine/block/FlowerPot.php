<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class FlowerPot extends Transparent{
	protected $id = self::FLOWER_POT_BLOCK;

	public function __construct(){

	}
	
	public function getName(){
		return "Flower Pot";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness(){
		return 5;
	}

	public function getDrops(Item $item){
		return [
			[Item::FLOWER_POT, 0, 1],
			$this->getContent()
		];
	}

	public function getContent(){
		$contentDamage = 0;
		switch($this->getDamage()){
			case 1:
				$content = Item::ROSE;
				break;
			case 2:
				$content = Item::DANDELION;
				break;
			case 3:
				$content = Item::SAPLING;
				break;
			case 4:
				$content = Item::SAPLING;
				$contentDamage = 1;
				break;
			case 5:
				$content = Item::SAPLING;
				$contentDamage = 2;
				break;
			case 6:
				$content = Item::SAPLING;
				$contentDamage = 3;
				break;
			case 7:
				$content = Item::RED_MUSHROOM;
				break;
			case 8:
				$content = Item::BROWN_MUSHROOM;
				break;
			case 9:
				$content = Item::CACTUS;
				break;
			case 10:
				$content = Item::DEAD_BUSH;
				break;
			case 11:
				$content = Item::TALL_GRASS;
				$contentDamage = 2;
				break;
			case 12:
				$content = Item::SAPLING;
				$contentDamage = 4;
				break;
			case 13:
				$content = Item::SAPLING;
				$contentDamage = 5;
				break;
			default:
				$content = Item::AIR;
		}
		return [$content, $contentDamage, 1];
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::SAPLING || $item->getId() === Item::BROWN_MUSHROOM || $item->getId() === Item::RED_MUSHROOM || $item->getId() === Item::ROSE || $item->getId() === Item::DEAD_BUSH || $item->getId() === Item::DANDELION || $item->getId() === Item::TALL_GRASS || $item->getId() === Item::CACTUS){
			$item->useOn($this);
			$meta = 0;
			switch($item->getId()){
				case ITEM::ROSE:
					$meta = 1;
					break;
				case Item::DANDELION:
					$meta = 2;
					break;
				case Item::RED_MUSHROOM:
					$meta = 7;
					break;
				case Item::BROWN_MUSHROOM:
					$meta = 8;
					break;
				case Item::CACTUS:
					$meta = 9;
					break;
				case Item::DEAD_BUSH:
					$meta = 10;
					break;
				case Item::SAPLING:
					$species = $item->getDamage();
					/*
					* GENERIC(0x00),
					* REDWOOD(0x01),
					* BIRCH(0x02),
					* JUNGLE(0x03),
					* ACACIA(0x04),
					* DARK_OAK(0x05),
					*/
					if($species == 0x00){
						$meta = 3;
					}elseif($species == 0x01){
						$meta = 4;
					}elseif($species == 0x02){
						$meta = 5;
					}elseif($species == 0x03){
						$meta = 6;
					}elseif($species == 0x04){
						$meta = 12;
					}else{
						$meta = 13;
					}
					break;
				case Item::TALL_GRASS:
					$species = $item->getDamage();
					if($species == 0x02) {
						$meta = 11;
					}
					break;
			}
			$this->setDamage($meta);
			$this->getLevel()->setBlock($this, $this, true);
			return true;
		}
		return false;
	}
}