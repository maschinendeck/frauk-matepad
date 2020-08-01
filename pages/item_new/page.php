<?php

    if (isset($_POST["name"]) && isset($_POST["costs"])) {

        // Create item and submit to store
        $item = new ItemData;
        $item->name = $_POST["name"];
        $item->costs = $_POST["costs"];
        $store->createItem($item);
        $store->writeToDisk();
        
        bindAndRender(__DIR__ . "template_post.html");
    } else {
        bindAndRender(__DIR__ . "template_pre.html");
    }

?>