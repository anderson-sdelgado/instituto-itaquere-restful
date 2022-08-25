<?php

namespace Repository;

use DB\MySQL;
use Exception;

class SecaoRepository extends MySQL
{
    public const TABELA = "secao_balancete";

    public function __construct()
    {
        parent::setTable(self::TABELA);
    }

    public function getAll()
    {
        try {
            $consulta = "SELECT         s1.codigo,
                                        s1.descricao,
                                        s1.codparente,
                                        s1.nivel,
                                        s1.posicao,
                                        CONCAT(' / ', REPLACE(CONCAT(COALESCE(s4.descricao, '-') , ' / ', COALESCE(s3.descricao, '-') , ' / ', COALESCE(s2.descricao, '-') , ' / ', COALESCE(s1.descricao, '-')), '- / ', '')) as caminho
                            FROM        secao_balancete s1
                            LEFT JOIN   secao_balancete s2 ON s2.codigo = s1.codparente
                            LEFT JOIN   secao_balancete s3 ON s3.codigo = s2.codparente
                            LEFT JOIN   secao_balancete s4 ON s4.codigo = s3.codparente
                            WHERE       0 IN (s1.codparente, 
                                            s2.codparente, 
                                            s3.codparente, 
                                            s4.codparente)
                            ORDER BY s1.posicao DESC";
            $stmt = $this->getDb()->query($consulta);
            return $stmt->fetchAll($this->getDb()::FETCH_ASSOC);
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
    
    public function getCodParente($codparente, $order)
    {
        try {
            $consulta = 'SELECT * FROM ' . self::TABELA  . ' WHERE codparente = ' . $codparente . ' ORDER BY posicao ' . $order;
            $stmt = $this->getDb()->prepare($consulta);
            $stmt->execute();
            return $stmt->fetchAll($this->getDb()::FETCH_ASSOC);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }


}