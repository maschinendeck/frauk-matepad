<?php

    if (isset($_POST["name"]) && isset($_POST["costs"])) {

        // Create item and submit to store
        $item = new ItemData;
        $item->name = $_POST["name"];
        $item->costs = $_POST["costs"];
        $store->createItem($item);
        $store->writeToDisk();

    }

?>