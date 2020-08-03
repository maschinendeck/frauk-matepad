<?php

    if (isset($_POST["name"])) {

        // Create user and submit to store
        $user = new UserData;
        $user->name = $_POST["name"];
        $user->balance = 0;
        $store->createUser($user);
        $store->writeToDisk();

        bindAndRenderTemplate(__DIR__ . "/template.post.html", null);
    } else {
        bindAndRenderTemplate(__DIR__ . "/template_form.html", null);
    }

?>