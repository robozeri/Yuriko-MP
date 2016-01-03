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
 
namespace pocketmine\item;

class Potion extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::POTION, $meta, $count, "ItaDevs");
        if($this->meta === 4){
            $this->name = "Akward Potion";
        }elseif($this->meta === 28){
            $this->name = "Potion Of Regeneration";
        }elseif($this->meta === 29){
            $this->name = "Potion Of Regeneration";
        }elseif($this->meta === 30){
            $this->name = "Potion Of Regeneration II";
        }elseif($this->meta === 14){
            $this->name = "Potion of Speed";
        }elseif($this->meta === 15){
            $this->name = "Potion Of Speed";
        }elseif($this->meta === 16){
            $this->name = "Potion Of Speed II";
        }elseif($this->meta === 12){
            $this->name = "Potion Of Fire Resistence";
        }elseif($this->meta === 13){
            $this->name = "Potion Of Fire Resistence";
        }elseif($this->meta === 21){
            $this->name = "Potion Of Healing";
        }elseif($this->meta === 22){
            $this->name = "Potion Of Healing II";
        }elseif($this->meta === 31){
            $this->name = "Potion Of Strenght";
        }elseif($this->meta === 32){
            $this->name = "Potion Of Strenght";
        }elseif($this->meta === 33){
            $this->name = "Potion Of Strenght II";
        }elseif($this->meta === 9){
            $this->name = "Potion Of Leaping";
        }elseif($this->meta === 10){
            $this->name = "Potion Of Leaping";
        }elseif($this->meta === 11){
            $this->name = "Potion Of Leaping II";
        }elseif($this->meta === 7){
            $this->name = "Potion Of Invisibility";
        }elseif($this->meta === 8){
            $this->name = "Potion Of Invisibility";
        }elseif($this->meta === 34){
            $this->name = "Potion Of Weakness";
        }elseif($this->meta === 35){
            $this->name = "Potion Of Weakness";
        }elseif($this->meta === 23){
            $this->name = "Potion Of Harming";
        }elseif($this->meta === 24){
            $this->name = "Potion Of Harming II";
        }elseif($this->meta === 25){
            $this->name = "Potion Of Poison";
        }elseif($this->meta === 26){
            $this->name = "Potion Of Poison";
        }elseif($this->meta === 27){
            $this->name = "Potion Of Poision II";
        }elseif($this->meta === 5){
            $this->name = "Potion Of Night Vision";
        }elseif($this->meta === 6){
            $this->name = "Potion Of Night Vision";
        }elseif($this->meta === 19){
            $this->name = "Potion Of Water Breathing ";
        }elseif($this->meta === 20){
            $this->name = "Potion Of Water Breathing ";
        }elseif($this->meta === 17){
            $this->name = "Potion Of Slowness";
        }elseif($this->meta === 18){
            $this->name = "Potion Of Slowness";
        }elseif($this->meta === 3){
            $this->name = "Thick Potion";
        }elseif($this->meta === 1){
            $this->name = "Mundane Potion";
        }elseif($this->meta === 2){   
            $this->name = "Mundane Potion";   
	    }
    }
}