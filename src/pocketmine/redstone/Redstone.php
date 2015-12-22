<?php

namespace pocketmine\redstone;

use pocketmine\block\Block;
use pocketmine\block\RedstoneDust;

class Redstone{

    public static function active(Block $source){
        $queue = new \SplPriorityQueue();
        $curLevel = $source->getPowerLevel() - 1;
        if($curLevel <= 0){
            return;
        }
        self::addToQueue($queue, $source);
        while(!$queue->isEmpty()){
            $updating = $queue->extract();
            if($curLevel > $updating->getPowerLevel()){
                $updating->setPowerLevel($curLevel);
                $updating->level->setBlock($updating, $updating, true);
                self::addToQueue($queue, $updating);
            }
        }
    }

    public static function activeByList(Block $source, $updateMap){
        $queue = new \SplPriorityQueue();
        $curLevel = $source->getPowerLevel() - 1;
        if($curLevel <= 0){
            return;
        }
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        self::addToQueue($queue, $source);
        while(!$queue->isEmpty()){
            list($updating, $curLevel) = $queue->extract();
            /** @var Block $updating */
            if($curLevel > $updating->getPowerLevel()){
                $updating->setPowerLevel($curLevel);
                $updating->level->setBlock($updating, $updating, true, true);
                if(isset($updateMap[$updating->locationHash()])){
                    unset($updateMap[$updating->locationHash()]);
                }
                self::addToQueue($queue, $updating);
            }
        }
    }

    public static function deactive(Block $source, $updateLevel){
        $queue = new \SplPriorityQueue();
        $sources = new \SplPriorityQueue();
        $updateMap = [];
        $curLevel = $updateLevel;
        if($curLevel <= 0){
            return;
        }
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        self::addToDeactiveQueue($queue, $source, [], $sources, $curLevel);
        while(!$queue->isEmpty()){
            list($updating, $curLevel) = $queue->extract();
            /** @var Block $updating */
            if($curLevel >= $updating->getPowerLevel()){
                $updating->setPowerLevel(0);
                $updateMap[$updating->locationHash()] = $updating;
                self::addToDeactiveQueue($queue, $updating, $updateMap, $sources, $curLevel);
            }else{
                $sources->insert($updating, $updating->getPowerLevel());
            }
        }
        while(!$sources->isEmpty()){
            //self::active() TODO
        }

        foreach($updateMap as $hash => $block){
            /** @var Block $block */
            $block->setPowerLevel(0);
            $block->getLevel()->setBlock($block, $block, true, true);
        }
    }

    public static function addToQueue(\SplPriorityQueue $queue, Block $location){
        if($location->getPowerLevel() <= 0){
            return;
        }
        for($s = 2; $s <= 5; $s++){
            $updating = $location->getSide($s);
            if($updating instanceof RedstoneDust){
                $queue->insert($updating, $updating->getPowerLevel() - 1);
            }
        }
    }

    public static function addToDeactiveQueue(\SplPriorityQueue $queue, Block $location, array $updateMap, \SplPriorityQueue $sources, $updateLevel){
        if($updateLevel <= 0){
            return;
        }
        for($s = 2; $s <= 5; $s++){
            $updating = $location->getSide($s);
            if($updating->isPowerSource() or ($updateLevel === 0 and $updating->isPowered())){
                $sources->insert($updating, $updating->getPowerLevel());
            }elseif($updating instanceof RedstoneDust){
                if(!isset($updateMap[$updating->locationHash()])){
                    $queue->insert($updating, $updating->getPowerLevel());
                }
            }
        }
    }

}