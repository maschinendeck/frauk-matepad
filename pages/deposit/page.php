<?php

    if (isset($_GET["value"]) && $currentUser) {
        $currentUser->balance += $_GET["value"];
        $store->writeToDisk();
        echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";
    } else {
        $depositOptions = array(
            array("value" =>   100, "img" =>   "100.jpg"),
            array("value" =>   200, "img" =>   "200.jpg"),
            array("value" =>   500, "img" =>   "500.jpg"),
            array("value" =>  1000, "img" =>  "1000.jpg"),
            array("value" =>  2000, "img" =>  "2000.jpg"),
            array("value" =>  5000, "img" =>  "5000.jpg"),
        );
    
        foreach ($depositOptions as $option) {
            $bindingsCharge = array("href" => $currentUser ? "?page=deposit&value=" . $option["value"]  : "?page=user_signin",
                                    "value" => number_format($option["value"] / 100.0, 2),
                                    "image" => $option["img"]);
            bindAndRenderTemplate(__DIR__ . "/template_deposit_option.html", $bindingsCharge);
        }
    }

?>