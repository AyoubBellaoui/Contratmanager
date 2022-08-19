<?php

    require ("../Connection/Config.php");

    session_start();    # resume session

    session_unset();    # free all variables on session

    session_destroy();  # destroy Opened session

    sleep(1);
    header("location: Login.php");
    exit;





