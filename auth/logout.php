<?php
session_start();
session_unset();
session_destroy();
header("Location: /spri/day24/blog23/");
exit;
