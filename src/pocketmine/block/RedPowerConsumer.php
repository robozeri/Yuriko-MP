<?php

namespace pocketmine\block;
/**
 * @deprecated
 */
interface RedPowerConsumer{

    public function isActivated();

    public function setActivated($bool); //aka onSignal
}