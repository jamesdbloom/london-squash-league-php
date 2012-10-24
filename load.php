<?php
/**
 * Bootstrap file for setting the ROOT_PATH constant and loading the config.php file.
 */
define('ROOT_PATH', dirname(__FILE__) . '/');
define('ROOT_OFFSET', '/');
error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);

// load error message framework
$message_bundle_class_file = ROOT_PATH . 'includes/messages/messages.php';
if (file_exists($message_bundle_class_file)) {
    require_once($message_bundle_class_file);
} else {
    die ("Can't load error messages");
}

// load config file
load::load_file('config', 'config.php');

// load error framework
load::load_file('includes/email', 'email.php');

// load error framework
load::load_file('includes/errors', 'error.php');

// load HTML utilities
load::load_file('includes/html', 'form.php');
load::load_file('includes/html', 'page.php');
load::load_file('includes/html', 'link.php');

// load HTTP utilities
load::load_file('includes/http', 'cookies.php');
load::load_file('includes/http', 'headers.php');
load::load_file('includes/http', 'parameters.php');
load::load_file('includes/http', 'urls.php');

// load security framework
load::load_file('includes/security', 'authentication.php');
load::load_file('domain/session', 'session.php');

// load seo framework
load::load_file('includes/seo', 'page_search_terms.php');

// load string utilities
load::load_file('includes/strings', 'strings.php');

// load input validation
load::load_file('includes/validation', 'input_validation.php');

// load database file
load::load_file('database', 'database.php');
new Database(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

class load
{
    public static function load_file($dir, $file)
    {
        $file_path = ROOT_PATH . $dir . '/' . $file;
        if (file_exists($file_path)) {
            require_once($file_path);
        } else {
            die (get_message('NO_FILE', 'config') . ' ' . $file_path);
        }
    }

    public static function include_file($dir, $file)
    {
        $file_path = ROOT_PATH . $dir . '/' . $file;
        if (file_exists($file_path)) {
            include $file_path;
        } else {
            die (get_message('NO_FILE', 'config') . ' ' . $file_path);
        }
    }
}
?>
