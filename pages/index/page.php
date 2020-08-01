<?php

    foreach ($store->getAllItems() as $item) {
        $bindings = array("id" => $item->id, "name" => $item->name, "costs" => $item->costs, "image" => $item->image);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

    $bindings = array();
    $bindings["name"] = $currentUser ? $currentUser->name : "No User";
    bindAndRenderTemplate(__DIR__ . "/template.html", $bindings);
?>