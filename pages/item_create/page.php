<?php

    if (isset($_POST["name"]) && isset($_POST["costs"])) {

        // Create item and submit to store
        $item = new ItemData;
        $item->name = $_POST["name"];
        $item->costs = $_POST["costs"];
        $store->createItem($item);
        $store->writeToDisk();
        
        bindAndRenderTemplate("item_create_post.html", null);
    } else {
        bindAndRenderTemplate("item_create_pre.html", null);
    }

?>