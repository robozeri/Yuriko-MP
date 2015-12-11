<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class RedstoneDust extends Flowable implements RedPowerConductor{
    protected $id = self::REDSTONE_DUST;
    protected $activated = false;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function setRedstoneOutput($power){
        $this->meta = $power;
    }

    public function onUpdate($type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if(($p = $this->getRedstoneInput()) > 0){ //Is receiving power (> 0)
                if(!$this->isActivated()){
                    $this->setActivated(true);
                }
                $this->setRedstoneOutput($p - 1);
            }else{
                if($this->isActivated()){
                    $this->setActivated(false);
                }
                $this->setRedstoneOutput(0);
            }
            $this->level->scheduleUpdate($this, 1);
            return Level::BLOCK_UPDATE_NORMAL;
        }elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
            $this->level->setBlock($this, $this, true, true, true);
            return Level::BLOCK_UPDATE_SCHEDULED;
        }
        return false;
    }

    public function getRedstoneInput(){
        $power = 0;
        for($s = 0; $s <= 5; $s++){
            $sideBlock = $this->getSide($s);
            if(($o = $sideBlock->getRedstoneOutput()) > $this->getRedstoneOutput()){
                $power += $o;
            }
            if($s === 0 or $s === 1){
                for($t = 2; $t <= 5; $t++){
                    $stepBlock = $sideBlock->getSide($t);
                    if($stepBlock->getId() === $this->id and ($o = $sideBlock->getSide($t)->getRedstoneOutput()) > $this->getRedstoneOutput()){
                        $power += $o;
                    }
                }
            }
        }
        return $power > 15 ? 15 : $power;
    }

    public function getRedstoneOutput(){
        return $this->meta;
    }

    public function isActivated(){
        return $this->activated === true;
    }

    public function setActivated($bool){
        $this->activated = $bool;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($face === 1 and !$this->getSide(0)->isTransparent()){ //Up
            $this->onUpdate(Level::BLOCK_UPDATE_NORMAL);
            return parent::place($item, $block, $target, $face, $fx, $fy, $fz, $player);
        }
        return false;
    }

    public function getDrops(Item $item)
    {
        return [
            [Item::REDSTONE_DUST, 0, 1],
        ];
    }
}