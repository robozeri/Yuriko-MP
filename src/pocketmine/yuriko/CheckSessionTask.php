<?php

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