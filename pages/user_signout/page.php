<?php

    setcookie(COOKIE_USER, ""); // Never Expire
    bindAndRenderTemplate(__DIR__ . "/template.html", null);

?>