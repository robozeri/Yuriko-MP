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
 
namespace pocketmine\item;

use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\item\Item;

class SwiftnessPotion extends Item{

$player = $e->getPlayer();

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SWIFTNESS_POTION, $meta, $count, "Swiftness Potion");
	}
    
    public function OnItemConsume(PlayerItemConsumeEvent $e){
        if($player->getInventory()->getItemOnHand(Item::SWIFTNESS_POTION)){
            $player->addEffect(Effect::getEffect(Effect::SWIFTNESS)->setDuration(180 * 20));
        }
    }
} 