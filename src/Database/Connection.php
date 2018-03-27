<?php

namespace Equidea\Database;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Database
 */
class Connection {

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @param   array   $config
     */
    public function __construct(array $config) {
        $this->connect($config);
    }

    /**
     * @param   array   $config
     *
     * @return  void
     */
    private function connect(array $config)
    {
        // Build DSN
        $dns = 'mysql:host='.$config['host'].';dbname='.$config['name'];

        // Set options
        $options = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$config['char']
        ];

        // Create new PDO object
        try
        {
            $this->connection = new \PDO(
                $dns, $config['user'], $config['password'], $options
            );

            $this->connection->setAttribute(
                \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
            );
        }
        catch (\PDOException $e)
        {
            echo 'Couldn\'t connect to database:' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  \PDOStatement
     */
    private function preparedStmt(string $sql, array $params)
    {
        // Prepare SQL
        $sql = trim($sql);
        $stmt = $this->connection->prepare($sql);

        // Bind parameters
        $names = array_keys($params);
        $elements = count($names);

        for ($i = 0; $i < $elements; $i++) {
            $stmt->bindParam(':'.ltrim($names[$i],':'), $params[$names[$i]]);
        }

        // Execute statement and return
        $stmt->execute();
        return $stmt;
    }

    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  int
     */
    public function cud(string $sql, array $params = null)
    {
        if (is_null($params)) {
            return $this->execute($sql);
        }
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * @param   string      $sql
     * @param   null|array  $params
     *
     * @return  \PDOStatement
     */
    public function query(string $sql, array $params = null)
    {
        if (is_null($params)) {
            $sql = trim($sql);
            $stmt = $this->connection->query($sql);
            return $stmt;
        }
        return $this->preparedStmt($sql, $params);
    }

    /**
     * @param   string  $sql
     *
     * @return  int
     */
    private function execute(string $sql) : int
    {
        $sql = trim($sql);
        $rows = $this->connection->exec($sql);
        return $rows;
    }
}
