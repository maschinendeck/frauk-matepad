<?php
  
    if (isset($_GET["user"])) {
        $user = $store->getUserByID($_GET["user"]);
        $store->signinUser($_GET["user"]);
        $bindings = array("username" => $user->name);
        bindAndRenderTemplate(__DIR__ . "/template_post.html", $bindings);
    } else {
        foreach ($store->getAllUser() as $user) {
            $bindings = array(  "id" => $user->id,
                                "name" => $user->name, 
                                "avatar" => $user->avatar);
            bindAndRenderTemplate(__DIR__ . "/template_user_select.html", $bindings);
        }
    }

?>