<?php

interface Mapper
{
    public function map(array $user_row);
}

class DAO
{
    protected static $db;

    public static function init(PDO $db)
    {
        self::$db = $db;
    }

    protected static $show_errors = DEBUG;
    protected static $show_queries = SHOW_QUERIES;

    protected static function load_value($query, array $parameters, $action)
    {
        $value = null;
        try {
            $stmt = self::$db->prepare($query);
            $stmt->execute($parameters);
            $value = $stmt->fetchColumn(0);
        } catch (PDOException $e) {
            $message = 'Unable to ' . $action . (self::$show_queries ? ' ' . $query . $e->getMessage() : '');
            if (self::$show_errors) {
                print $message . '<br/>';
            }
            $GLOBALS['errors']->add('dao_error', $message);
        }

        return $value;
    }

    protected static function load_object($query, array $parameters, Mapper $mapper, $action)
    {
        $all_results = self::load_all_objects($query, $parameters, $mapper, $action);
        if (count($all_results) > 0) {
            return reset($all_results);
        }
        return null;
    }

    protected static function load_all_objects($query, array $parameters, Mapper $mapper, $action)
    {
        $all_results = array();
        try {
            $stmt = self::$db->prepare($query);
            $stmt->execute($parameters);
            while ($user_row = $stmt->fetch()) {
                $all_results[] = $mapper->map($user_row);
            }
        } catch (PDOException $e) {
            $message = 'Unable to ' . $action . (self::$show_queries ? ' ' . $query . $e->getMessage() : '');
            if (self::$show_errors) {
                print $message . '<br/>';
            }
            $GLOBALS['errors']->add('dao_error', $message);
        }

        return $all_results;
    }

    protected static function execute($query, $action)
    {
        try {
            self::$db->exec($query);
        } catch (PDOException $e) {
            $message = 'Unable to ' . $action . (self::$show_queries ? ' ' . $query . $e->getMessage() : '');
            if (self::$show_errors) {
                print $message . '<br/>';
            }
            $GLOBALS['errors']->add('dao_error', $message);
        }
    }

    protected static function insert_update_delete_create($query, array $parameters, $action)
    {
        try {
            $stmt = self::$db->prepare($query);
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            $message = 'Unable to ' . $action . (self::$show_queries ? ' ' .  "<br/>" . $query . "<br/>" . $e->getMessage() : '');
            if (self::$show_errors) {
                print $message . '<br/>';
            }
            $GLOBALS['errors']->add('dao_error', $message);
        }
        return self::$db->lastInsertId();
    }

    protected static function sanitize_email($email)
    {
        return trim(strtolower($email));
    }

    protected static function sanitize_value($name)
    {
        return trim($name);
    }
}

class Database
{
    private static $module_directory = "database";

    private static $show_errors = DEBUG;

    public function __construct($dbuser, $dbpassword, $dbname, $dbhost)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        try {
            $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            DAO::init($db);
        } catch (Exception $e) {
            print 'Error connecting to database' . (self::$show_errors ? ' ' . "mysql:host=$dbhost;dbname=$dbname" . $e->getMessage() : '') . '<br/>';
        }
    }

    public function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return '$error_message_bundle: ' . self::$module_directory . '<br/>' .
            ' $show_errors: ' . self::$show_errors . '<br/>';
    }
}


?>