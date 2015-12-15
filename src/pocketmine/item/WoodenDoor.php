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

namespace pocketmine\item;

use pocketmine\block\Block;

class WoodenDoor extends Item{

	public function __construct($meta = 0, $count = 1){
		switch($meta){
			case 0:
			default:
				$this->block = Block::get(Block::OAK_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Oak Door");
				break;
			case 1:
				$this->block = Block::get(Block::SPRUCE_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Spruce Door");
				break;
			case 2:
				$this->block = Block::get(Block::BIRCH_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Birch Door");
				break;
			case 3:
				$this->block = Block::get(Block::JUNGLE_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Jungle Door");
				break;
			case 4:
				$this->block = Block::get(Block::ACACIA_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Acacia Door");
				break;
			case 5:
				$this->block = Block::get(Block::DARK_OAK_DOOR_BLOCK);
				parent::__construct(self::WOODEN_DOOR, $meta, $count, "Dark Oak Door");
				break;
		}
	}

	public function getMaxStackSize(){
		return 1;
	}
}