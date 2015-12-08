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
 * Brought to you by @AryToNeX, @Fycarman and @luca28pet.
 * Copyright 2015 ItalianDevs4PM. All rights reserved.
 * 
 * ORIGINAL POCKETMINE-MP LICENSE:
 * PocketMine-MP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author AryToNeX, fycarman, luca28pet (ItalianDevs4PM)
 * @link   http://github.com/ItalianDevs4PM
 *
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