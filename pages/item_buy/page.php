<?php
    $bindings = array();

    if (isset($_GET["id"]) && isset($currentUser)) {

        // Fetch item and user
        $item = $store->getItemByID($_GET["id"]);
        $user = $store->getUserByID($currentUser->id);
        $user->balance -= $item->costs;
        $store->writeToDisk();

        $bindings["costs"] = $item->costs;
        $bindings["balance"] = $user->balance; 
        
        echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";

    } else {
        bindAndRenderTemplate(__DIR__ . "/template.html", $bindings);
    }

?>