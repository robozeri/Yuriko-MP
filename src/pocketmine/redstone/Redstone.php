<?php

namespace pocketmine\redstone;

use pocketmine\block\Block;
use pocketmine\block\RedstoneDust;
use pocketmine\Server;

class Redstone{

    public static function active(Block $source){
        $queue = new \SplPriorityQueue();
        $curLevel = $source->getPowerLevel() - 1;
        if($curLevel <= 0){
            return;
        }
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        self::addToQueue($queue, $source);
        $prev = null;
        while(!$queue->isEmpty()){
            $ex = $queue->extract();
            $updating = $ex["data"];
            $power = $ex["priority"];
            /** @var Block $updating*/
            if($power !== $updating->getPowerLevel()){
                $updating->setPowerLevel($power);
                $updating->level->setBlock($updating, $updating, true);
                self::addToQueue($queue, $updating);
            }
        }
    }

    public static function deactive(Block $source, $updateLevel){
        $queue = new \SplPriorityQueue();
        $curLevel = $updateLevel;
        if($curLevel <= 0){
            return;
        }
        self::addToDeactiveQueue($queue, $source);
        while(!$queue->isEmpty()){
            $updating = $queue->extract();
            if($updating->getPowerLevel() < $source->getPowerLevel()){
                $updating->setPowerlevel(0);
                $updating->level->setBlock($updating, $updating, true);
                self::addToDeactiveQueue($queue, $updating);
            }
        }
    }

    public static function addToQueue(\SplPriorityQueue $queue, Block $location){
        if($location->getPowerLevel() <= 0){
            return;
        }
        for($s = 2; $s <= 5; $s++){
            $updating = $location->getSide($s);
            if($updating instanceof RedstoneDust and $updating->getPowerLevel() < $location->getPowerLevel()){
                $queue->insert($updating, $location->getPowerLevel() - 1);
                Server::getInstance()->getLogger()->debug("Inserted");
            }
        }
    }

    public static function addToDeactiveQueue(\SplPriorityQueue $queue, Block $location){
        if($location->getPowerLevel() <= 0){
            return;
        }
        for($s = 0; $s <= 5; $s++){
            $updating = $location->getSide($s);
            if($updating->getPowerLevel() > 0 and count($updating->getPowerSources()) === 1){
                $queue->insert($updating, $location->getPowerLevel() - 1);
            }
        }
    }

}