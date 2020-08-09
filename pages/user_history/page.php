<?php

    echo "<div class=\"history-content\">";

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

    if ($currentUser) {

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
        bindAndRenderTemplate(__DIR__  . "/template_head.html", array("username" => $currentUser->name));
        foreach ($groupedSales as $saleGroup) {
            $headerBindings = array("dateStr" => $saleGroup->dateStr);
            bindAndRenderTemplate(__DIR__ . "/template_group.html", $headerBindings);
            foreach ($saleGroup->sales as $sale) {
                $saleItem = $store->getItemByID($sale->itemid);
                $saleBindings = array("time" => date("H:i:s", intval($sale->datetime)),
                                      "name" => $saleItem ? $saleItem->name : "Deleted Item",
                                      "price" => is_numeric($sale->price) ? number_format($sale->price / 100.0, 2) . "€" : $sale->price);
                bindAndRenderTemplate(__DIR__ . "/template_entry.html", $saleBindings);
            }
        }

    }

    echo "</div>";

?>