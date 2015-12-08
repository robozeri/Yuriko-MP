<?php

/*
 *
 * __   __          _ _               __  __ ____  
 * \ \ / /   _ _ __(_) | _____       |  \/  |  _ \ 
 *  \ V / | | | '__| | |/ / _ \ _____| |\/| | |_) |
 *   | || |_| | |  | |   < (_) |_____| |  | |  __/ 
 *   |_| \__,_|_|  |_|_|\_\___/      |_|  |_|_|
 *
 * This is an unofficial PocketMine-MP fork.
 * This fork is more advanced than original one.
 * Brought to you by @AryToNeX, @Fycarman and @luca28pet
 *
 */

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