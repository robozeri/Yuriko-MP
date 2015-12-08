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

class Redstone extends Solid implements RedPowerSource{
	protected $id = self::REDSTONE_BLOCK;

	public function __construct(){

	}

	public function getHardness(){
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Redstone Block";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::REDSTONE_BLOCK, 0, 1],
			];
		}
		return [];
	}

	public function getPower(){
		return 15;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		for($s = 0; $s <= 6; $s++){
			$sideBlock = $this->getSide($s);
			if($sideBlock instanceof RedPowerConsumer){
				$sideBlock->setReceiving($this);
				$sideBlock->onSignal($this->getPower() - 1);
				if($sideBlock instanceof RedPowerConductor){
					$sideBlock->setPower($this->getPower() - 1);
				}
			}
		}
		return parent::place($item, $block, $target, $face, $fx, $fy, $fz, $player);
	}

	public function onBreak(Item $item){
		for($s = 0; $s <= 6; $s++){
			$sideBlock = $this->getSide($s);
			if($sideBlock instanceof RedPowerConsumer){
				if(count($sideBlock->getReceiving()) === 1){
					$sideBlock->removeReceiving($this);
					$sideBlock->onSignal(0);
					if($sideBlock instanceof RedPowerConductor){
						$sideBlock->setPower(0);
					}
				}
			}
		}
		return parent::onBreak($item);
	}


	//TODO when redstone will get more advanced
	public function onSignal($on){

	}

	public function isReceiving(){
		return false;
	}

	public function getReceiving(){
		return [];
	}

	public function removeReceiving(Block $block){

	}

	public function setReceiving(Block $block){

	}
}