<?php

namespace pocketmine\redstone;

use pocketmine\block\Block;

class Redstone{

    public static function active(Block $source){
        if(!$source->isPowerSource()){
            return;
        }
        $queue = new \SplPriorityQueue();
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        self::addToQueue($queue, $source);
        while(!$queue->isEmpty()){
            $ex = $queue->extract();
            $updating = $ex["data"];
            $power = $ex["priority"];
            /** @var Block $updating*/
            $updating->setPowerLevel($power);
            $updating->level->setBlock($updating, $updating, true);
            self::addToQueue($queue, $updating);
        }
    }

    public static function addToQueue(\SplPriorityQueue $queue, Block $location){
        $updateLevel = $location->getPowerLevel() - 1;
        if($updateLevel <= 0){
            return;
        }
        for($s = 2; $s <= 5; $s++){
            $sideBlock = $location->getSide($s);
            if($sideBlock->getId() === Block::REDSTONE_DUST){
                if($sideBlock->getPowerLevel() !== $updateLevel){
                    $queue->insert($sideBlock, $updateLevel);
                }
            }
        }
    }

    public static function deactive(Block $source, $updateLevel){
        $queue = new \SplPriorityQueue();
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        if(!$source->isPowerSource()){
            return;
        }
        self::addToDeactiveQueue($queue, $source, $updateLevel);
        while(!$queue->isEmpty()){
            $ex = $queue->extract();
            $updating = $ex["data"];
            $power = $ex["priority"];
            /** @var Block $updating */
            $updating->setPowerLevel(0);
            $updating->level->setBlock($updating, $updating, true);
            self::addToDeactiveQueue($queue, $updating, $power);
        }
    }

    public static function addToDeactiveQueue(\SplPriorityQueue $queue, Block $location, $updateLevel){
        if($updateLevel <= 0){
            return;
        }
        for($s = 0; $s <= 5; $s++){
            $sideBlock = $location->getSide($s);
            if($sideBlock->getPowerLevel() === $updateLevel - 1){
                $queue->insert($sideBlock, $sideBlock->getPowerLevel());
            }
        }
    }

}