<?php 
    $bindings = array();
    if ($currentUser) {
        $bindings["userName"] = $currentUser->name;
        $bindings["userAction"] = "?page=user_signout";
    } else {
        $bindings["userName"] = "Sign In";
        $bindings["userAction"] = "?page=user_signin";
    }

    $bindings["coffeinTotal"] = $store->getStatistic()->coffeinSold . "mg";

    bindAndRenderTemplate(__DIR__ . "/template.html", $bindings);
?>