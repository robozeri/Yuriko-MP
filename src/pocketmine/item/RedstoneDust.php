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
        parent::__construct(self::REDSTONE_DUST, $meta, $count, "Redstone Dust");
        $this->block = Block::get(Block::REDSTONE_DUST, $meta);
    }
}