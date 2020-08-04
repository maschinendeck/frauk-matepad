<?php
  
    if (isset($_GET["user"])) {
        $user = $store->getUserByID($_GET["user"]);
        $store->signinUser($_GET["user"]);
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