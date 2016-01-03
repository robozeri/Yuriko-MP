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
 * Copyright 2016 ItalianDevs4PM.
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

namespace pocketmine\level\particle;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class SpellParticle extends GenericParticle{
	public function __construct(Vector3 $pos, $r = 0, $g = 0, $b = 0, $a = 255){
		parent::__construct($pos, LevelEventPacket::EVENT_PARTICLE_SPLASH, (($a & 0xff) << 24) | (($r & 0xff) << 16) | (($g & 0xff) << 8) | ($b & 0xff));
	}

	public function encode(){
		$pk = new LevelEventPacket();
		$pk->evid = LevelEventPacket::EVENT_PARTICLE_SPLASH;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->data;
		return $pk;
	}
}