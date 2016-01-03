<?php

/*
 *
 * __   __          _ _               __  __ ____  
 * \ \ / /   _ _ __(_) | _____       |  \/  |  _ \ 
 *  \ V / | | | '__| | |/ / _ \ _____| |\/| | |_) |
 *   | || |_| | |  | |   < (_) |_____| |  | |  __/ 
 *   |_| \__,_|_|  |_|_|\_\___/      |_|  |_|_|
 *
 * Yuriko-MP, a kawaii-powered PocketMine-based software
 * for Minecraft: Pocket Edition
 * Copyright 2015 ItalianDevs4PM.
 *
 * This work is licensed under the Creative Commons
 * Attribution-NonCommercial-NoDerivatives 4.0
 * International License.
 * 
 *
 * @author ItalianDevs4PM
 * @link   http://github.com/ItalianDevs4PM
 *
 *
 */

namespace pocketmine\yuriko;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;

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
        $result = @unserialize(Utils::getUrl("http://yuriko.com/yuriko_signatures.php?sign=".$this->signature));
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