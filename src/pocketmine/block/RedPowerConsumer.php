<?php

namespace pocketmine\block;

interface RedPowerConsumer{

    public function isActivated();

    public function setActivated($bool); //aka onSignal
}