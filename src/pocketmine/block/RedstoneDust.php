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

    public function getPower(){
        return $this->meta;
    }

    public function setPower($power){
        $this->meta = $power;
    }

    public function onUpdate($type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            $powered = false;
            for($s = 0; $s <= 6; $s++){
                $sideBlock = $this->getSide($s);
                if($sideBlock instanceof RedPowerSource and $sideBlock->getPower() > $this->getPower()){
                    $powered = $sideBlock->getPower() - 1;
                }
            }

            if($powered > 0){ //Is receiving power (> 0)
                $this->setPower($powered);
                if(!$this->isActivated()){
                    $this->setActivated(true);
                }
            }else{
                $this->setPower(0);
                if($this->isActivated()){
                    $this->setActivated(false);
                }
            }
            $this->level->scheduleUpdate($this, 1);
            return Level::BLOCK_UPDATE_NORMAL;
        }elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
            $this->level->setBlock($this, $this, true, true);
            return Level::BLOCK_UPDATE_SCHEDULED;
        }
        return false;
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

}