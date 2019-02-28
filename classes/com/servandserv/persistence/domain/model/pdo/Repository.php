<?php

namespace com\servandserv\persistence\domain\model\pdo;

class Repository {

    protected $conn;

    public function __construct( $conn )
    {
        $this->conn = $conn;
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        try { $this->conn->commit(); } catch (\Exception $e) {}
    }

    public function rollback()
    {
        try { $this->conn->rollBack(); } catch (\Exception $e) {}
    }
    
    // формируем строку вида ?,?,?,? любой длины для подстановки в запросы типа INSERT
    protected function makePlaceholders( $text, $count = 0, $separator = "," )
    {
        $result = [];
        if( $count > 0 ) {
            for( $x = 0; $x < $count; $x++ ) {
                $result[] = $text;
            }
        }

        return implode( $separator, $result );
    }
    
    protected function makeStatement( array $params ) {
        $query = "";
        foreach( $params as $col => $val ) {
            $query .= ",`".substr( $col, 1 )."`=".$col;
        }
        return substr( $query, 1 );
    }
}