<?php

namespace Repository;

use DB\MySQL;
use Exception;

class NoticiasRepository extends MySQL
{

    public const TABELA = "noticias";

    public function __construct()
    {
        parent::setTable(self::TABELA);
    }

    public function count()
    {
        try {
            $consulta = "SELECT COUNT(codigo) as qtde FROM " . self::TABELA;
            $stmt = parent::getDb()->query($consulta);
            $registros = $stmt->fetchAll(parent::getDb()::FETCH_ASSOC);
            return $registros;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

    public function codLast()
    {
        try {
            $consulta = "SELECT AUTO_INCREMENT as codigo FROM information_schema.tables WHERE table_name = '" . self::TABELA . "' AND table_schema = 'itaquere'";
            $stmt = parent::getDb()->query($consulta);
            $registros = $stmt->fetchAll(parent::getDb()::FETCH_ASSOC);
            return $registros;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

    public function getFilter($page = null, $countpage = null, $order = null, $filter = null)
    {
        try {
            $select = "SELECT * FROM " . self::TABELA;
            if(!empty($filter)){
                $select = $select . " WHERE CONVERT(codigo, CHARACTER) LIKE '%" . $filter . "%'" . 
                " OR titulo like  '%" . $filter . "%'" . 
                " OR conteudo like  '%" . $filter . "%'"; 
            }
            if(!empty($order)){
                $select = $select . " ORDER BY " . $order;
            }
            if(!empty($countpage)){
                $select = $select . " LIMIT " . $countpage;
                if(!empty($page)){
                    $offset = $countpage * ($page - 1);
                    $select = $select . " OFFSET " . $offset;
                }
            }
            $stmt = parent::getDb()->query($select);
            $registros = $stmt->fetchAll(parent::getDb()::FETCH_ASSOC);
            return $registros;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

}