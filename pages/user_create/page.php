<?php

    if (isset($_POST["name"])) {

        $userName = $_POST["name"];
        $userAvatarURL = $_POST["avatar"];
        $userAvatarFile = "./images/user/avatar_" . $userName;

        // Download avatar from provided URL
        // TODO: This is horrible for security - Any better ideas?
        file_put_contents($userAvatarFile, fopen($userAvatarURL, "r"));

        // Create user and submit to store
        $user = new UserData;
        $user->name = $userName;
        $user->avatar = $userAvatarFile;
        $user->balance = 0;
        $store->createUser($user);
        $store->writeToDisk();

        // SignIn the newly created user
        $user->signin();

        $bindings = array("userName" => $userName, "userAvatar" => $userAvatarFile);
        bindAndRenderTemplate(__DIR__ . "/template_post.html", $bindings);
    } else {
        bindAndRenderTemplate(__DIR__ . "/template_form.html", null);
    }

?>