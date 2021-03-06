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

class PoweredRail extends Flowable{ //implemets RedstoneTool

    protected $id = self::POWERED_RAIL;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function getName(){
        return "Powered Rail";
    }

    public function getHardness(){
        return 0.1;
    }

    public function getToolType(){
        return Tool::TYPE_PICKAXE;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        $down = $this->getSide(0);
        $blockNorth = $this->getSide(2); //Gets the blocks around them
        $blockSouth = $this->getSide(3);
        $blockEast = $this->getSide(5);
        $blockWest = $this->getSide(4);//Activated rail + 0x8 to meta
        if($down->isTransparent() === false){
            if($blockNorth->getId() === $this->id){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 0), true, true);
                $blockNorth->setDamage(0);
            }
            if($blockSouth->getId() === $this->id){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 0), true, true);
                $blockSouth->setDamage(0);
            }
            if($blockEast->getId() === $this->id){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 1), true, true);
                $blockEast->setDamage(1);
            }
            if($blockWest->getId() === $this->id){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 1), true, true);
                $blockWest->setDamage(1);
            }
            //TODO: Add support for Curved and Sloped rails.
            if($blockNorth->getId() === self::RAIL){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 0), true, true);
                $blockNorth->setDamage(0);
            }
            if($blockSouth->getId() === self::RAIL){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 0), true, true);
                $blockSouth->setDamage(0);
            }
            if($blockEast->getId() === self::RAIL){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 1), true, true);
                $blockEast->setDamage(1);
            }
            if($blockWest->getId() === self::RAIL){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 1), true, true);
                $blockWest->setDamage(1);
            }
            //
            if($this->getId() !== $this->id){
                $this->getLevel()->setBlock($block, Block::get(Item::POWERED_RAIL, 0), true, true);
            }
            return true;
        }
        return false;
    }

    public function getDrops(Item $item){
        $drops = [];
        $drops[] = [Item::POWERED_RAIL, 0, 1];
        return $drops;
    }
}