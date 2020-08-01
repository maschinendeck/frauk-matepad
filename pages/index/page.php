<?php

    $bindings = array();
    $bindings["name"] = $currentUser ? $currentUser->name : "No User";

    foreach ($store->getAllItems() as $item) {
        echo "<a href=\"?page=item_buy&id=" . $item->id . "\"\>";
        echo $item->name; 
        echo " ";
        echo $item->costs;
        echo "</a><br>";
    }

    bindAndRenderTemplate(__DIR__ . "/template.html", $bindings);
?>