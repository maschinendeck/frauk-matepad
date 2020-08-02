<?php

    foreach ($store->getAllItems() as $item) {
        $bindings = array(  "id" => $item->id, 
                            "name" => $item->name, 
                            "price" => is_numeric($item->costs) ? number_format($item->costs / 100.0, 2) . "€" : $item->costs,
                            "image" => $item->image);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

?>