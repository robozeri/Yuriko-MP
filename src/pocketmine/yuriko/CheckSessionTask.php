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

namespace pocketmine\yuriko;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class CheckSessionTask extends AsyncTask{

    private $signature;

    public function __construct($signature){
        $this->signature = $signature;
    }

    public function onRun(){
        /*
         * return: [
         *   "check" => true
         * ]
         */
        $result = @unserialize(file_get_contents("http://yuriko.com/yuriko_signatures.php?sign=".$this->signature));
        if(is_array($result)){
            $this->setResult($result["check"]);
        }else{
            $this->setResult(true);
        }
    }

    public function onCompletion(Server $server){
        if(!$this->getResult()){
            $server->getLogger()->critical(TextFormat::RED."Unofficial Yuriko Build detected! Halting...");
            $server->shutdown();
        }
    }

}