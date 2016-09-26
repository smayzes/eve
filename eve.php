#!/usr/bin/env php
<?php

// Autoload
require_once __DIR__ . '/vendor/autoload.php';

// Configuration
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Go!
(new Eve\Eve())->run();
