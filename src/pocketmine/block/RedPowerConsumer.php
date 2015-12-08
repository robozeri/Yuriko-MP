<?php

namespace pocketmine\block;

interface RedPowerConsumer{

    public function isReceiving();

    public function getReceiving();

    public function setReceiving(Block $block);

    public function removeReceiving(Block $block);

    public function onSignal($power);
}