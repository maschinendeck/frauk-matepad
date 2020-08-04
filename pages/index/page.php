<?php


    foreach ($store->getAllItems() as $item) {
        $bindings = array(  "href" => $currentUser ? "?page=item_buy&id=" . $item->id : "?page=user_signin",
                            "name" => $item->name, 
                            "price" => is_numeric($item->costs) ? number_format($item->costs / 100.0, 2) . "€" : $item->costs,
                            "image" => $item->image);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

?>