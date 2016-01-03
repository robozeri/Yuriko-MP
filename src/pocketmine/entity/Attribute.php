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

namespace pocketmine\entity;

use pocketmine\network\protocol\UpdateAttributesPacket;
use pocketmine\Player;

class Attribute{
	private $id;
	protected $minValue;
	protected $maxValue;
	protected $defaultValue;
	protected $currentValue;
	protected $name;
	protected $shouldSend;
	/** @var Player */
	protected $player;

	public function __construct($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend, $player){
		$this->id = (int) $id;
		$this->name = (string) $name;
		$this->minValue = (float) $minValue;
		$this->maxValue = (float) $maxValue;
		$this->defaultValue = (float) $defaultValue;
		$this->shouldSend = (float) $shouldSend;
		$this->currentValue = $this->defaultValue;
		$this->player = $player;
	}

	public function getMinValue(){
		return $this->minValue;
	}

	public function setMinValue($minValue){
		if($minValue > $this->getMaxValue()){
			throw new \InvalidArgumentException("Value $minValue must be smaller than the maxValue!");
		}
		$this->minValue = $minValue;
		return $this;
	}

	public function getMaxValue(){
		return $this->maxValue;
	}

	public function setMaxValue($maxValue){
		if($maxValue < $this->getMinValue()){
		throw new \InvalidArgumentException("Value $maxValue must be bigger than the minValue!");
		}
		$this->maxValue = $maxValue;
		return $this;
	}

	public function getDefaultValue(){
		return $this->defaultValue;
	}

	public function setDefaultValue($defaultValue){
		if($defaultValue > $this->getMaxValue()){
			throw new \InvalidArgumentException("Value $defaultValue must be smaller than the maxValue! Using maxValue as defaultValue.");
			$defaultValue = $this->getMaxValue();
		}elseif($defaultValue < $this->getMinValue()){
			throw new \InvalidArgumentException("Value $defaultValue must be bigger than the minValue! Using minValue as defaultValue.");
			$defaultValue = $this->getMinValue();
		}
		$this->defaultValue = $defaultValue;
		return $this;
	}

	public function getValue(){
		return $this->currentValue;
	}

	public function setValue($value){
		if($value > $this->getMaxValue()){
			$value = $this->getMaxValue();
		}elseif($value < $this->getMinValue()){
			$value = $this->getMinValue();
		}
		$this->currentValue = $value;
		if($this->shouldSend){
			$this->send();
		}
	}

	public function getName(){
		return $this->name;
	}

	public function getId(){
		return $this->id;
	}

	public function isSyncable(){
		return $this->shouldSend;
	}

	public function send(){
		$pk = new UpdateAttributesPacket();
		$pk->entityId = 0;
		$pk->entries = [$this];
		$this->player->dataPacket($pk);
	}
}