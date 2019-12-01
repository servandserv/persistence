<?php

namespace com\servandserv\persistence\domain\service\pdo;

class ConnectionFactory
{
    private static $instance;
    private $connections = [];

    /**
    private function __construct( $dns, $user, $pass, $opt )
    {
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        try {
            $this->connections[] =  new \PDO( $dns, $user, $pass, $opt );
        } catch ( \PDOException $e ) {
            die( "Connection error: ".$e->getMessage() );
        }
    }
    */

    public static function getConnect( $dns, $user, $pass, $opt )
    {
        if( NULL === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance->createConnect(  $dns, $user, $pass, $opt );
    }
    
    private function createConnect( $dns, $user, $pass, $opt )
    {
        $key = $this->connectionUID( $dns, $user );
        if( !isset( $this->connections[$key] ) ) {
            $opt = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ];
            try {
                $this->connections[$key] =  new \PDO( $dns, $user, $pass, $opt );
            } catch ( \PDOException $e ) {
                die( "Connection error: ".$e->getMessage() );
            }
        }
        return $this->connections[$key];
    }
    
    private function connectionUID( $dns, $user ) 
    {
        return $key = md5( $dns.$user );
    }

}