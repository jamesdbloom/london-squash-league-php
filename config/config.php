<?php
/** The name of the database */
define('DB_NAME', 'db143442_squash_beta');

/** MySQL database username */
define('DB_USER', 'db143442_squash');

/** MySQL database password */
define('DB_PASSWORD', 'g1t20php12');

/** MySQL hostname */
define('DB_HOST', $_ENV{DATABASE_SERVER});

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('RANDOM_SEED', 'SlE59NZhwz5RzTzB6hFpg ZBD02wMP1dDdnYqHQ7zLDP');

/** Absolute path to the root directory. */
if ( !defined('ROOT_PATH') )
    define('ROOT_PATH', dirname(__FILE__) . '/');

define('DEBUG', true);
define('SHOW_QUERIES', true);
