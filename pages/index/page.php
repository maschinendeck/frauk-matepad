<?php

    echo "<div class=\"index-content\">";

    $bindingsCharge = array("href" => $currentUser ? "?page=deposit" : "?page=user_signin",
                            "name" => "Deposit", 
                            "price" => "Rich Bitch",
                            "image" => "deposit.jpg");
    bindAndRenderTemplate(__DIR__ . "/template_deposit.html", $bindingsCharge);

    foreach ($store->getAllItems() as $item) {
        $bindings = array(  "id" => $item->id,
                            "href" => $currentUser ? "?page=item_buy&id=" . $item->id : "?page=user_signin",
                            "name" => $item->name, 
                            "price" => is_numeric($item->costs) ? number_format($item->costs / 100.0, 2) . "€" : $item->costs,
                            "image" => $item->image);
        bindAndRenderTemplate(__DIR__ . "/template_item.html", $bindings);
    }

    if ($currentUser) {

        class SalesByDay {
            public $date;
            public $dateStr;
            public $sales;
    
            function __construct($saleDate) {
                $this->date = date("Y-m-d", $saleDate);
                $this->dateStr = date("d-m-Y", $saleDate);
                $this->sales = array();
            }
        }

        // Group sales by day and sort most recent first
        // TODO: Sort items in day
        $groupedSales = array();
        $currentSaleDay = null;
        foreach ($currentUser->sales as $sale) {
            $saleDate = date("Y-m-d", intval($sale->datetime));
            if ($currentSaleDay == null || $currentSaleDay->date !== $saleDate) {
                if ($currentSaleDay) {
                    array_push($groupedSales, $currentSaleDay);
                }
                $currentSaleDay = new SalesByDay(intval($sale->datetime));
            }
            array_push($currentSaleDay->sales, $sale);
        }
        array_push($groupedSales, $currentSaleDay);
        usort($groupedSales, function($a, $b) { return strcmp($b->date, $a->date); });

        // Render history
        $userinfo = bindAndOutputTemplate(__DIR__  . "/template_head.html", array("username" => $currentUser->name));
        foreach ($groupedSales as $saleGroup) {
            $headerBindings = array("dateStr" => $saleGroup->dateStr);
            $userinfo .= bindAndOutputTemplate(__DIR__ . "/template_group.html", $headerBindings);
            foreach ($saleGroup->sales as $sale) {
                $saleItem = $store->getItemByID($sale->itemid);
                $saleBindings = array("time" => date("H:i:s", intval($sale->datetime)),
                                      "name" => $saleItem ? $saleItem->name : "Deleted Item",
                                      "price" => is_numeric($sale->price) ? number_format($sale->price / 100.0, 2) . "€" : $sale->price);
                $userinfo .= bindAndOutputTemplate(__DIR__ . "/template_entry.html", $saleBindings);
            }
        }

        $bindingsUser = array(  "balance" => number_format($currentUser->balance / 100.0, 2) . "€",
                                "colorStyle" => $currentUser->balance < 0 ? "balance-red" : "balance-green",
                                "userinfo" => $userinfo);

        bindAndRenderTemplate(__DIR__ . "/template_user.html", $bindingsUser);
    }

    echo "</div>";

?>