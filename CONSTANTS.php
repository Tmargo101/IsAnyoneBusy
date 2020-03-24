<?php

/* Filename: CONSTANTS.php
 * Purpose: Define program constants
 * NOTE: This file excluded from deployment.  To make changes, edit on server.
 *
 * Author: Tom Margosian
 * Date: 3/23/20
 */

// Change application-wide constants here
$SET_APPLICATION_NAME = "Who's Busy";
$SET_BACKGROUND_IMAGE = "";

// Set MySQL Database credentials
$SET_DB_SERVER = "localhost";
$SET_DB_USER = "";
$SET_DB_PASSWORD = "";
$SET_DB_DATABASE = "";

// Define system-wide constants for project use
define("APPLICATION_NAME", $SET_APPLICATION_NAME);
define("BG_IMAGE", $SET_BACKGROUND_IMAGE);
define("DB_SERVER", $SET_DB_SERVER);
define("DB_USERNAME", $SET_DB_USER);
define("DB_PASSWORD", $SET_DB_PASSWORD);
define("DB_DATABASE", $SET_DB_DATABASE);

