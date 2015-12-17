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
 
namespace Block;
 
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\entity\Entity;

class QuartzOre extends Solid{
	protected $id = self::QUARTZ_ORE;

	public function __construct(){

	}

	public function getHardness(){
		return 3;
	}

	public function getName(){
		return "Quartz Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onBreak(Item $item){
		if($this->getRandomExperience($item) > 0){
			Entity::createEntity("ExperienceOrb", $this->level->getChunk($this->x >> 4, $this->z >> 4), new Compound("", [
					"Pos" => new Enum("Pos", [
						new Double("", $this->x),
						new Double("", $this->y),
						new Double("", $this->z)
					]),
					"Motion" => new Enum("Motion", [
						new Double("", 0),
						new Double("", 0),
						new Double("", 0)
					]),
					"Rotation" => new Enum("Rotation", [
						new Float("", 0),
						new Float("", 0)
					]),
			]))->spawnToAll();
		}
		return parent::onBreak($item);
	}

	public function getRandomExperience(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return mt_rand(2, 5);
		}
		return 0;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::QUARTZ, 0, 1],
			];
		}
		return [];
	}
}