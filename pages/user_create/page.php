<?php

    if (isset($_POST["name"])) {
        $userName = $_POST["name"];

        // Download the avatar (if any)
        $userAvatarFile = "./images/user/anon.jpg";
        if (isset($_POST["avatar"]) && $_POST["avatar"] !== "") {
            $userAvatarURL = $_POST["avatar"];
            $userAvatarFile = "./images/user/avatar_" . md5($userName);
            
            try {
                $avatarFileContent = file_get_contents($userAvatarURL);
                if ($avatarFileContent !== false) {
                    file_put_contents($userAvatarFile, $avatarFileContent);
                }
            } catch (Exception $e) {
                $bindings = array("reason" => "Unable to download the provided image file",
                                  "emsg" => $e->getMessage());
                bindAndRenderTemplate("error.html", $bindings);
            }
        }

        // Create user and submit to store
        $user = new UserData;
        $user->name = $userName;
        $user->avatar = $userAvatarFile;
        $user->balance = 0;
        $store->createUser($user);
        $store->writeToDisk();

        // SignIn the newly created user
        $store->signinUser($user->id);

        $bindings = array("userName" => $userName, "userAvatar" => $userAvatarFile);
        bindAndRenderTemplate("user_create_confirm.html", $bindings);
    } else {
        bindAndRenderTemplate("user_create_form.html", null);
    }

?>