<?php

    $bindings = array();
    $bindings["name"] = $currentUser ? $currentUser->name : "No User";

    foreach ($store->getAllItems() as $item) {
        $bindings = array("itemid" => $item->id, "name" => $item->name, "costs" => $item->costs);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

    bindAndRenderTemplate(__DIR__ . "/template.html", $bindings);
?>