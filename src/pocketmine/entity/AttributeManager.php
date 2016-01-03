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

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\entity\Attribute;
use pocketmine\network\Network;
use pocketmine\network\protocol\MobEffectPacket;
use pocketmine\network\protocol\UpdateAttributesPacket;
use pocketmine\Player;

class AttributeManager{
    const MAX_HEALTH = 0;
    const MAX_HUNGER = 1;
    const EXPERIENCE = 2;
    const EXPERIENCE_LEVEL = 3;

    /** @var Attribute[] */
    protected $attributes = [];
    /** @var Player */
    protected $player;

    public function __construct($player){
        $this->player = $player;
    }

    public function init(){
        self::addAttribute(self::MAX_HEALTH, "generic.health", 0, 20, 20, true);
        self::addAttribute(self::MAX_HUNGER, "player.hunger", 0, 20, 20, true);
        self::addAttribute(self::EXPERIENCE, "player.experience", 0, 24791, 0, true);
        self::addAttribute(self::EXPERIENCE_LEVEL, "player.level", 0, 24791, 0, true);
    }

    public function getPlayer() {
        return $this->getPlayer();
    }

    /**
     * @param int    $id
     * @param string $name
     * @param float  $minValue
     * @param float  $maxValue
     * @param float  $defaultValue
     * @param bool   $shouldSend
     * @return Attribute
     */
    public function addAttribute($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend = false){
        if($minValue > $maxValue or $defaultValue > $maxValue or $defaultValue < $minValue){
            throw new \InvalidArgumentException("Invalid ranges: minValue: $minValue, maxValue: $maxValue, defaultValue: $defaultValue");
        }
        return $this->attributes[(int) $id] = new Attribute($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend, $this->player);
    }

    /**
     * @param $id
     * @return null|Attribute
     */
    public function getAttribute($id){
        return isset($this->attributes[$id]) ? clone $this->attributes[$id] : null;
    }

    /**
     * @param $name
     * @return null|Attribute
     */
    public function getAttributeByName($name){
        foreach($this->attributes as $a){
            if($a->getName() === $name){
                return clone $a;
            }
        }
        return null;
    }

    public function sendAll(){
        $pk = new UpdateAttributesPacket();
        $pk->entityId = 0;
        $pk->entries = $this->attributes;
        $this->player->dataPacket($pk);
    }

    public function resetAll(){
        foreach($this->attributes as $attribute){
            $attribute->setValue($attribute->getDefaultValue());
        }
    }
}