<?php

namespace Equidea\Database;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Database
 */
class Database {
    
    /**
     * @var \Equidea\Database\Connection
     */
    private static $connection;
    
    /**
     * @param   array   $config
     *
     * @return  void
     */
    public static function connect(array $config) {
        self::$connection = new Connection($config);
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  \stdClass
     */
    public static function select($sql, array $params = [])
    {
        $result = self::$connection->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public static function insert($sql, array $params = []) {
        self::$connection->cud($sql, $params);
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public static function update($sql, array $params = []) {
        self::$connection->cud($sql, $params);
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public static function delete($sql, array $params = []) {
        self::$connection->cud($sql, $params);
    }
    
    /**
     * @return  void
     */
    public static function disconnect() {
        self::$connection = null;
    }
}