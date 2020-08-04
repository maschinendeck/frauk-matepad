<?php
  
    if (isset($_GET["user"])) {
        $user = $store->getUserByID($_GET["user"]);
        $store->signinUser($_GET["user"]);
        // TODO: Terrible redirect
        echo "<meta http-equiv=\"refresh\" content=\"0;url=?page=index\">";
    } else {
        foreach ($store->getAllUser() as $user) {
            $bindings = array(  "id" => $user->id,
                                "name" => $user->name, 
                                "avatar" => $user->avatar);
            bindAndRenderTemplate(__DIR__ . "/template_user_select.html", $bindings);
        }
    }

?>