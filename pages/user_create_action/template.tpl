<?php

    if (isset($_POST["name"])) {

        // Create user and submit to store
        $user = new UserData;
        $user->name = $_POST["name"];
        $user->balance = 0;
        $store->createUser($user);
        $store->writeToDisk();

        echo "<a href=\"?page=user_signin_action&user=\"" . $user->id . ">Continue as user</a><br>";
    } else {
        echo "<a href=\"?page=user_signin\">Select user</a><br>";
        echo "<a href=\"?page=user_create\">Create user</a><br>";
    }

?>