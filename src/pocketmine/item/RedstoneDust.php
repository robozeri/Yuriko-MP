<?php
/**
 * Created by PhpStorm.
 * User: Luca Petrucci
 * Date: 08/12/2015
 * Time: 12:41
 */

namespace pocketmine\item;

use pocketmine\block\Block;

class RedstoneDust extends Item{

    public function __construct($meta = 0, $count = 1){
        $this->id = self::REDSTONE_DUST & 0xffff;
        $this->meta = $meta !== null ? $meta & 0xffff : null;
        $this->count = (int) $count;
        $this->name = "Redstone Dust";

        $this->block = Block::get(Block::REDSTONE_DUST, $this->meta);
        $this->name = $this->block->getName();
    }
}