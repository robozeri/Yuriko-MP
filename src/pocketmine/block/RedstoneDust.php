<?php
/**
 * Created by PhpStorm.
 * User: Luca Petrucci
 * Date: 08/12/2015
 * Time: 12:45
 */

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;

class RedstoneDust extends Flowable implements RedPowerConductor{
    protected $id = self::REDSTONE_DUST;
    protected $signals = [];

    public function __construct(){

    }

    public function getPower(){
        return $this->meta;
    }

    public function setPower($power){
        $this->meta = $power;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        for($s = 0; $s <= 6; $s++){
            $sideBlock = $this->getSide($s);
            if($sideBlock instanceof RedPowerSource){
                $this->setReceiving($sideBlock);
                $this->setPower($sideBlock->getPower() - 1);
                $this->onSignal($sideBlock->getPower() - 1);
            }
        }
        return parent::place($item, $block, $target, $face, $fx, $fy, $fz, $player);
    }

    public function onBreak(Item $item){
        for($s = 0; $s <= 6; $s++){
            $sideBlock = $this->getSide($s);
            if($sideBlock instanceof RedPowerConductor){
                if(count($sideBlock->getReceiving()) === 1){
                    $sideBlock->removeReceiving($this);
                    $sideBlock->setPower(0);
                }
            }
        }
        return parent::onBreak($item);
    }

    public function isReceiving(){
        return count($this->signals);
    }

    public function getReceiving(){
        return $this->signals;
    }

    public function setReceiving(Block $block){
        if(!in_array($block, $this->signals)){
            $this->signals[] = $block;
        }
    }

    public function removeReceiving(Block $block){
        if(($key = array_search($block, $this->signals)) !== false){
            unset($this->signals[$key]);
        }
    }

    public function onSignal($power){
        if($power > 0){
            for($s = 0; $s <= 6; $s++){
                $sideBlock = $this->getSide($s);
                if($sideBlock instanceof RedPowerConsumer){
                    $sideBlock->setReceiving($this);
                    $sideBlock->onSignal($this->getPower());
                    if($sideBlock instanceof RedPowerConductor and $sideBlock->getPower() < $this->getPower()){
                        $sideBlock->setPower($this->getPower() - 1);
                    }
                }
            }
        }else{
            //TODO
        }
    }

}