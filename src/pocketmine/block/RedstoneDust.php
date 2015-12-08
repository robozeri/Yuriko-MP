<?php

namespace pocketmine\block;

use pocketmine\level\Level;

class RedstoneDust extends Flowable implements RedPowerConductor{
    protected $id = self::REDSTONE_DUST;
    protected $activated = false;

    public function __construct(){

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
                $powered = ($sideBlock instanceof RedPowerSource and $sideBlock->getPower() > $this->getPower());
            }
            if(!$powered){
                $this->setPower(0);
                $this->setActivated(false);
                //$this->level->updateAround($this);
            }

            for($s = 0; $s <= 6; $s++){
                $sideBlock = $this->getSide($s);
                if($sideBlock instanceof RedPowerConductor and $powered){
                    if($sideBlock->getPower() <= $this->getPower() and $this->getPower() > 0){
                        $sideBlock->setPower($this->getPower() - 1);
                    }
                }elseif($sideBlock instanceof RedPowerConsumer){
                    if($powered and !$sideBlock->isActivated()){
                        $sideBlock->setActivated(true);
                    }
                }
            }
            $this->level->setBlock($this, $this);
            return Level::BLOCK_UPDATE_NORMAL;
        }
        return false;
    }

    public function isActivated(){
        return $this->activated === true;
    }

    public function setActivated($bool){
        $this->activated = $bool;
    }

}