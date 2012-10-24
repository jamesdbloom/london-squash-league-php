<?php
/**
 * The basic config for site.
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db143442_squash');

/** MySQL database username */
define('DB_USER', 'db143442_squash');

/** MySQL database password */
define('DB_PASSWORD', 'squashBooking');

/** MySQL hostname */
define('DB_HOST', $_ENV{DATABASE_SERVER});
//define('DB_HOST', '127.0.0.1');
//define('DB_HOST', 'internal-db.s143442.gridserver.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 */
define('AUTH_KEY', 'jMLRv7jB 4Jgh1WXD QRDYIj38 i1Iv8QeR 7zbmvJh8');
define('SECURE_AUTH_KEY', 'bpahgUpi xyX5pr7W 8A7xLkF8 PGMP5gko cZwzTuq5');
define('LOGGED_IN_KEY', 'hgCYVKhD AXIGsuhS Jyz4soii jCBLDx11 CSCJKl5Z');
define('NONCE_KEY', 'hc26y8zC BYRpOztF xjkUEkKz NoRWwkOn M5lUuHZa');
define('AUTH_SALT', '8JJon1rr kiNI6LLX Aof5gFs5 ce1MgGmq HMbxiGwT');
define('SECURE_AUTH_SALT', 'LLyZa5UT nRRT6mKy jJxicncU CpU7wYgW NUjEfYw2');
define('LOGGED_IN_SALT', 'CV8P1ozj VdKVWgKJ xStTQWo3 2lV7mrO5 cdBTRrFR');
define('NONCE_SALT', 'UNVdAU44 FxtXC8Pk 6s1UbDZn wAkqdM7q XdzoNWq7');
define('RANDOM_SEED', 'UNVdAU44 FxtXC8Pk 6s1UbDZn wAkqdM7q XdzoNWq7');

/** Absolute path to the root directory. */
if ( !defined('ROOT_PATH') )
    define('ROOT_PATH', dirname(__FILE__) . '/');

define('DEBUG', false);
define('SHOW_QUERIES', true);
