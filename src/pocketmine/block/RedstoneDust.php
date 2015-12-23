<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\redstone\Redstone;

class RedstoneDust extends Flowable{
    protected $id = self::REDSTONE_DUST;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function setPowerLevel($power){
        parent::setPowerLevel($power);
        $this->meta = $power;
        if($power > 0){
            $this->setPowerSource(true);
        }else{
            $this->setPowerSource(false);
        }
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($face === 1 and !$this->getSide(0)->isTransparent()){ //Up
            $this->setPowerLevel(max(0, $this->getNeighbourPowerLevel() - 1));
            $block->level->setBlock($block, $this, true, true);
            Redstone::active($this);
            return true;
        }
        return false;
    }

    public function onBreak(Item $item){
        $level = $this->getPowerLevel();
        $this->level->setBlock($this, new Air(), true, false);
        Redstone::deactive($this, $level);
        return true;
    }

    public function getDrops(Item $item){
        return [
            [Item::REDSTONE_DUST, 0, 1],
        ];
    }
}