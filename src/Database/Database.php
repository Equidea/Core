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
    private $connection;

    /**
     * @param   array   $config
     */
    public function __construct(array $config) {
        $this->connection = new Connection($config);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  array
     */
    public function select(string $sql, array $params = []) : array
    {
        $result = $this->connection->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public function insert(string $sql, array $params = []) : int {
        return $this->connection->cud($sql, $params);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public function update(string $sql, array $params = []) : int {
        return $this->connection->cud($sql, $params);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public function delete(string $sql, array $params = []) : int {
        return $this->connection->cud($sql, $params);
    }

    /**
     * @return  void
     */
    public function disconnect() {
        $this->connection = null;
    }
}
