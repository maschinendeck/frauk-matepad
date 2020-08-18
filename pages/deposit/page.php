<?php

    if (isset($_GET["value"]) && $currentUser) {
        $currentUser->balance += $_GET["value"];
        $store->writeToDisk();
        echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";
    } else {
        $depositOptions = array(
            array("value" => "Back", "img" => "back.jpg", "link" => "?page=index"),
            array("value" =>   100, "img" =>   "100.jpg"),
            array("value" =>   200, "img" =>   "200.jpg"),
            array("value" =>   500, "img" =>   "500.jpg"),
            array("value" =>  1000, "img" =>  "1000.jpg"),
            array("value" =>  2000, "img" =>  "2000.jpg"),
            array("value" =>  5000, "img" =>  "5000.jpg"),
        );

        echo "<div class='index-content'>";
        foreach ($depositOptions as $option) {
            // Generate link
            $linkTo = $currentUser ? "?page=deposit&value=" . $option["value"] : "?page=user_signin";
            if (isset($option["link"])) {
                $linkTo = $option["link"];
            }

            $bindingsCharge = array("href" => $linkTo,
                                    "value" => is_numeric($option["value"]) ?
                                                number_format($option["value"] / 100.0, 2) . "€":
                                                $option["value"],
                                    "image" => $option["img"]);
            bindAndRenderTemplate("deposit_option.html", $bindingsCharge);
        }
        echo "</div>";
    }

?>
