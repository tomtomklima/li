<?php

namespace li;

session_start();
session_destroy();

header('Location: index.php');

die();