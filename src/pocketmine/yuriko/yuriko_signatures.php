<?php

/*
 *
 * __   __          _ _               __  __ ____  
 * \ \ / /   _ _ __(_) | _____       |  \/  |  _ \ 
 *  \ V / | | | '__| | |/ / _ \ _____| |\/| | |_) |
 *   | || |_| | |  | |   < (_) |_____| |  | |  __/ 
 *   |_| \__,_|_|  |_|_|\_\___/      |_|  |_|_|
 *
 * This is an unofficial PocketMine-MP fork.
 * This fork is more advanced than original one.
 * Brought to you by @AryToNeX, @Fycarman and @luca28pet.
 * Copyright 2015 ItalianDevs4PM. All rights reserved.
 * 
 * ORIGINAL POCKETMINE-MP LICENSE:
 * PocketMine-MP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author AryToNeX, fycarman, luca28pet (ItalianDevs4PM)
 * @link   http://github.com/ItalianDevs4PM
 *
 *
 */

$signatures = [];

if(!isset($_GET["sign"])) return;

$submittedSignature = $_GET["sign"];

$result = [
    "check" => in_array($submittedSignature, $signatures)
];

echo serialize($result);

?>