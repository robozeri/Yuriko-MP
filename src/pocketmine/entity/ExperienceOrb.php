<?php

/*
 *
 * __   __          _ _               __  __ ____  
 * \ \ / /   _ _ __(_) | _____       |  \/  |  _ \ 
 *  \ V / | | | '__| | |/ / _ \ _____| |\/| | |_) |
 *   | || |_| | |  | |   < (_) |_____| |  | |  __/ 
 *   |_| \__,_|_|  |_|_|\_\___/      |_|  |_|_|
 *
 * Yuriko-MP, a kawaii-powered PocketMine-MP based software
 * for Minecraft: Pocket Edition
 * Copyright 2015 ItalianDevs4PM.
 *
 * This work is licensed under the Creative Commons
 * Attribution-NonCommercial-NoDerivatives 4.0
 * International License.
 * 
 *
 * @author AryToNeX, fycarman, luca28pet (ItalianDevs4PM)
 * @link   http://github.com/ItalianDevs4PM
 *
 *
 */

namespace pocketmine\entity;


use pocketmine\level\format\FullChunk;
use pocketmine\network\Network;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;

class ExperienceOrb extends Entity{
    const NETWORK_ID = 69;

    public $collected = false;
	protected $amount = 0;

	public function __construct(FullChunk $chunk, $nbt){
		parent::__construct($chunk, $nbt);
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
		
		$this->timings->startTiming();
		
		$hasUpdate = parent::onUpdate($currentTick);
		$collector = null;

		foreach($this->getLevel()->getPlayers() as $p){
			if(!$this->collected){
				if($this->distance($p) < 7){  //6 or less
					$collector = $p;
					$this->collected = true;
				}
			}
		}

		if($this->age > 1200 || $this->collected){
			$this->kill();
			$hasUpdate = true;
		}
		
		if($collector !== null){
		    $collector->giveExp($this->getAmount());
        }

		$this->timings->stopTiming();
		
		return $hasUpdate;
	}

	public function spawnTo(Player $player) {
		$pk = new SpawnExperienceOrbPacket();
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->count = $this->getAmount();
		$player->dataPacket($pk->setChannel(Network::CHANNEL_ENTITY_SPAWNING));
		parent::spawnTo($player);
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setAmount($amount){
		$this->amount = $amount;
	}
}
