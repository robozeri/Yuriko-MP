<?php

namespace pocketmine\item;

class RawRabbit extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_RABBIT, $meta, $count, "Raw Rabbit");
	}
}
