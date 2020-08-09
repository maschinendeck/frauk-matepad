<?php

    if (isset($_GET["id"]) && isset($currentUser)) {

        // Fetch item and user and make the sale
        $item = $store->getItemByID($_GET["id"]);
        $user = $store->getUserByID($currentUser->id);
        $user->balance -= $item->costs;

        // Register the sale in the user history
        $sale = new Sale;
        $sale->datetime = time();
        $sale->itemid = $item->id;
        $sale->price = $item->costs;
        array_push($user->sales, $sale);
        
        // Adjust Statistic
        $store->getStatistic()->coffeinSold += $item->coffein;
        $store->writeToDisk();

        echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";

    }

?>