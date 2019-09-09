<?php

namespace Ariwf3\Blog_oop\Application\Classes\Config;

class Database {

    protected $pdo;
    private $databaseSourceName              = 'mysql:host=localhost;dbname=blog_oop';
    private $databaseLogin                   = 'root';
    private $databasePassword                = '';
    private $pdoException_utf8_fetchObj      = array(
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    public function __construct()
    {
        $this->setPdo( new \PDO($this->databaseSourceName, $this->databaseLogin, $this->databasePassword, $this->pdoException_utf8_fetchObj) );   
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
     * protectWithHtmlSpecialCharsAndTrim 
     * 
     * Protects the values and removes excess spaces of a given array values with the htmlspecialchars() and trim() functions
     *
     * @param array $arrayParams The array that will contain the parameters to be protected
     *
     * @return array|null
     */
    public function protectWithHtmlSpecialCharsAndTrim(array $arrayParams = []) {

        if ( !empty($arrayParams) )
        {
            foreach( $arrayParams as $keys => $param )
            {
                $arrayParams[$keys] = htmlspecialchars(trim($param));
            }
            return $arrayParams;
        }
        
    }


    /**
      * prepareExecute makes a prepared request with variable protection, returns a PDOStatement object
      *
      * @param  string $sqlQuery 
      * @param  array|null $arrayParams The array that will contain the parameters to execute the prepared query (optional)
      *
      * @return object PDOStatement
    */

    
    public function prepareExecute(string $sqlQuery, array $arrayParams = [])
    {

        $query = $this->pdo->prepare($sqlQuery);

        $protectedArrayParams = $this->protectWithHtmlSpecialCharsAndTrim($arrayParams);

        $query->execute($protectedArrayParams);
        return $query;
    }


    /**
     * queryAllFetchClass 
     * 
     * Retrieves all posts and returns them as an array of instances of the class specified using the FETCH_CLASS method
     *
     * @param  string $sqlQuery
     * @param  array|null $arrayParams The array that will contain the parameters to execute the prepared request
     * @param  string $class the classname of the entity requested
     *
     * @return array
     */
    public function queryAllFetchClass( string $sqlQuery, $class, array $arrayParams = [] ) :array
    {
        $query = $this->prepareExecute($sqlQuery, $arrayParams);

        $entity_namespace = "Ariwf3\\Blog_oop\\Application\\Classes\\Entity";
        
        return $query->fetchAll(\PDO::FETCH_CLASS, $entity_namespace . '\\' . $class);
    }

    /**
     * queryAllFetchAssoc 
     * 
     * performs a protected prepared query and returns several associative result arrays with the fetchAll() method and PDO::FETCH_ASSOC constant as parameter
     *
     * @param  string $sqlQuery
     * @param  array $arrayParams
     *
     * @return array
     */
    public function queryAllFetchAssoc( string $sqlQuery, array $arrayParams = [] ) :array
    {
        $query = $this->prepareExecute($sqlQuery, $arrayParams);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * queryOneFetchAssoc
     * 
     *  performs a protected prepared query and returns one associative result array with the fetch() method and the FETCH_ASSOC constant as parameter
     *
     * @param  string $sqlQuery
     * @param  array $arrayParams The table that will contain the parameters to execute the prepared request
     *
     * @return array
     */
    public function queryOneFetchAssoc(string $sqlQuery, array $arrayParams = []) :array
    {
        
        $query = $this->prepareExecute($sqlQuery, $arrayParams);

        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}