<?php

namespace pocketmine\event\player;

use pocketmine\Player;

/**
 * Called when a player first start aiming the bow
 */
class PlayerBowAimEvent extends PlayerEvent{
    public static $handlerList = null;

    public function __construct(Player $player){
        $this->player = $player;
    }
}