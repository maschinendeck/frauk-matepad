<?php
  
    if (isset($_GET["user"])) {
        $user = $store->getUserByID($_GET["user"]);
        $store->signinUser($_GET["user"]);
        // TODO: Terrible redirect
        if (isset($_GET["iid"])) {
            echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=item_buy&id=" . $_GET["iid"] . "\">";
        } else {
            echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";
        }    
    } else {
        foreach ($store->getAllUser() as $user) {
            $bindings = array(  "id" => $user->id,
                                "name" => $user->name, 
                                "avatar" => $user->avatar,
                                "attriid" => isset($_GET["iid"]) ? "&iid=" . $_GET["iid"] : "");
            bindAndRenderTemplate("user_select.html", $bindings);
        }
    }

?>