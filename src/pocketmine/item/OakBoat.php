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
use pocketmine\entity\Boat;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\Player;

class OakBoat extends Item{

    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::OAK_BOAT, $meta, $count, "Oak Boat");
    }

    public function canBeActivated(){
        return true;
    }

    public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
        $realPos = $block->getSide($face);

        $boat = Entity::createEntity("Boat", $player->getLevel()->getChunk($realPos->x >> 4, $realPos->z >> 4), new Compound("", [
            "Pos" => new Enum("Pos", [
                new Double("", $realPos->x),
                new Double("", $realPos->y),
                new Double("", $realPos->z)
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
        ]));
        $boat->spawnToAll();

        --$this->count;

        if($this->count <= 0){
            $player->getInventory()->setItemInHand(Item::get(Item::AIR));
            return true;
        }

        $player->getInventory()->setItemInHand($this);
        return true;
    }
}