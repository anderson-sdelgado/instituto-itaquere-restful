<?php

namespace Repository;

use DB\MySQL;
use Exception;

class DocumentoRepository extends MySQL
{
    public const TABELA = "documento_balancete";

    public function __construct()
    {
        parent::setTable(self::TABELA);
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

    public function getCodSecao($secao, $order)
    {
        try {
            $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE secao = ' . $secao . ' ORDER BY posicao ' . $order;
            $stmt = $this->getDb()->prepare($consulta);
            $stmt->execute();
            return $stmt->fetchAll($this->getDb()::FETCH_ASSOC);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

    public function getAll()
    {
        try {
            $consulta = 'SELECT * FROM ' . self::TABELA . ' ORDER BY posicao DESC';
            $stmt = $this->getDb()->query($consulta);
            return $stmt->fetchAll($this->getDb()::FETCH_ASSOC);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

}