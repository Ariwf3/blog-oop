<?php

namespace Ariwf3\Blog_oop\Application\Classes\Config;

class Database {

    protected $pdo;
    private $dataSourceName = 'mysql:host=localhost;dbname=blog_oop';
    private $databaseLogin = 'root';
    private $databasePassword = '';
    private $errmode_utf8_fetchObj = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');


    public function __construct()
    {
        $this->setPdo( new \PDO($this->dataSourceName, $this->databaseLogin,$this->databasePassword,$this->errmode_utf8_fetchObj) );   
    }

    /** 
     * setPdo initiates the pdo connection with a PDO instance as a parameter
     *
     * @param  \PDO $db_init
     *
     * @return void
     */
    public function setPdo(\PDO $db_init)
    {
        $this->pdo = $db_init;
    }

     /**
      * prepareExecute makes a prepared request with variable protection, returns a PDOStatement object
      *
      * @param  string $sqlQuery
      * @param  array $array
      *
      * @return object PDOStatement
      */


     public function prepareExecute(string $sqlQuery, array $array = [])
    {

        $query = $this->pdo->prepare($sqlQuery);

        if ( !empty($array) )
        {
            foreach( $array as $keys => $values )
                {
                    $values = htmlspecialchars($values);
                }
        }

        $query->execute($array);
        return $query;
    }


    /**
     * queryAllFetchClass
     *
     * @param  string $sqlQuery
     * @param  array|null $array
     * @param  string $class the classname of the entity
     *
     * @return array
     */
    public function queryAllFetchClass( string $sqlQuery, $class, array $array = [] ) :array
    {
    
        if ( !empty($array) )
        {
            foreach( $array as $keys => $values )
                {
                    $values = htmlspecialchars($values);
                }
        }
    
        $query = $this->pdo->prepare($sqlQuery);
        $query->execute($array);

        $entity_namespace = "Ariwf3\\Blog_oop\\Application\\Classes\\Entity";
        
        return $query->fetchAll(\PDO::FETCH_CLASS, $entity_namespace . '\\' . $class);
    }

    /**
     * queryAllFetchAssoc performs a protected prepared query and returns several associative result arrays with the fetchAll() method and FETCH_ASSOC method as parameter
     *
     * @param  string $sqlQuery
     * @param  array $array
     *
     * @return array
     */
    public function queryAllFetchAssoc( string $sqlQuery, array $array = array() ) :array
    {
    
        if ( !empty($array) )
        {
            foreach( $array as $keys => $values )
                {
                    $values = htmlspecialchars($values);
                }
        }
    
        $query = $this->pdo->prepare($sqlQuery);
        $query->execute($array);

        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * queryOneFetchAssoc performs a protected prepared query and returns one associative result array with the fetch() method and the FETCH_ASSOC method as parameter
     *
     * @param  string $sqlQuery
     * @param  array $array
     *
     * @return array
     */
    public function queryOneFetchAssoc(string $sqlQuery, array $array = array()) :array
    {
        if ( !empty($array) )
        {
            foreach( $array as $keys => $values )
                {
                    $values = htmlspecialchars($values);
                }
        }
        
        $query = $this->pdo->prepare($sqlQuery);
        $query->execute($array);

        
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}