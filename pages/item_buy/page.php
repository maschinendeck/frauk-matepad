<?php
    $bindings = array();

    if (isset($_GET["id"]) && isset($currentUser)) {

        // Fetch item and user
        $item = $store->getItemByID($_GET["id"]);
        $user = $store->getUserByID($currentUser->id);
        $user->balance -= $item->costs;
        $store->writeToDisk();

        $bindings["costs"] = $item->costs;
        $bindings["bindings"] = $user->balance; 

    } else {
        echo "Ne das war nix";
    }

    echo $mustache->render($template, $bindings);
?>