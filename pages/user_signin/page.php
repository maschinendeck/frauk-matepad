<?php
  
    if (isset($_GET["user"])) {
        $user = $store->getUserByID($_GET["user"]);
        setcookie(COOKIE_USER, $user->id, time() + 300); // Expire in 5Minutes)
        $bindings = array("username" => $user->name);
        bindAndRenderTemplate(__DIR__ . "/template_post.html", $bindings);
    } else {
        bindAndRenderTemplate(__DIR__ . "/template_form.html", null);
        $users = $store->getAllUser();
        foreach ($users as $user) {
            $bindings = array("userid" => $user->id, "username" => $user->name);
            bindAndRenderTemplate(__DIR__ . "/template_user_select.html", $bindings);
        }
    }

?>