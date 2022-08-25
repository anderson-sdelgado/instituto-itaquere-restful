<?php

namespace Repository;

use DB\MySQL;
use Exception;

class GaleriaNoticiaRepository extends MySQL
{

    public const TABELA = "galeria_noticia";

    public function __construct()
    {
        parent::setTable(self::TABELA);
    }

    public function getPorCodNoticia($codigo)
    {
        try {
            $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE cod_noticia = :codigo';
            $stmt = parent::getDb()->prepare($consulta);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            return $stmt->fetchAll(parent::getDb()::FETCH_ASSOC);
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
            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 404);
        }
    }

}