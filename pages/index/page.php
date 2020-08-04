<?php

    $bindingsCharge = array("href" => $currentUser ? "?page=deposit" : "?page=user_signin",
                            "name" => "Deposit", 
                            "price" => "Rich Bitch",
                            "image" => "deposit.jpg");
    bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindingsCharge);

    foreach ($store->getAllItems() as $item) {
        $bindings = array(  "href" => $currentUser ? "?page=item_buy&id=" . $item->id : "?page=user_signin",
                            "name" => $item->name, 
                            "price" => is_numeric($item->costs) ? number_format($item->costs / 100.0, 2) . "€" : $item->costs,
                            "image" => $item->image);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

    if ($currentUser) {
        $bindingsUser = array(  "balance" => number_format($currentUser->balance / 100.0, 2) . "€",
                                "colorStyle" => $currentUser->balance < 0 ? "balance-red" : "balance-green");
        bindAndRenderTemplate(__DIR__ . "/template_user.html", $bindingsUser);
    }

?>