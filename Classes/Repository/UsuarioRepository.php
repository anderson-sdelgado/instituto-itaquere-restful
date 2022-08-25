<?php

namespace Repository;

use DB\MySQL;
use Exception;
use Util\ConstantesGenericasUtil;

class UsuarioRepository extends MySQL
{
    public const TABELA = "usuarios";

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

    public function getFilter($page = null, $countpage = null, $order = null, $filter = null)
    {
        try {
            $select = "SELECT * FROM " . self::TABELA;
            if(!empty($filter)){
                $select = $select . " WHERE CONVERT(codigo, CHARACTER) LIKE '%" . $filter . "%'" . 
                " OR nome like  '%" . $filter . "%'"; 
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

    public function login($data)
    {
        try {
            $consultaToken = 'SELECT codigo FROM ' .self::TABELA . ' WHERE nome = :nome AND senha = :senha';
            $stmt = parent::getDb()->prepare($consultaToken);
            foreach($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
            if($stmt->rowCount() === 1){
                return ConstantesGenericasUtil::TIPO_SUCESSO;
            } else {
                throw new Exception(ConstantesGenericasUtil::TIPO_ERRO, 404);
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

}