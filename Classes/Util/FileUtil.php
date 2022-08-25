<?php

namespace Util;

use Exception;

class FileUtil
{

    public static function updateImage($codigo)
    {

        try{

            if($_FILES['image']['type'] === 'image/jpeg'){
                $name = 'noticia' . $codigo . '.jpg';
            }
            else if($_FILES['image']['type'] === 'image/png'){
                $name = 'noticia' . $codigo . 'png';
            }
            else{
                throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE_TIPO, 404);
            }

            if (!move_uploaded_file($_FILES['image']['tmp_name'], DIR_IMG . $name)) {
                throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE, 404);
            }

            return $name;

        } catch (Exception $exception){
            throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE, 404);
        }

    }

    public static function updateDocument($codigo)
    {

        try{

            if($_FILES['document']['type'] === 'application/pdf'){
                $name = 'documento' . $codigo . '.pdf';
            }
            else{
                throw new Exception(ConstantesGenericasUtil::MSG_ERR0_DOCUMENT_TIPO, 404);
            }

            if (!move_uploaded_file($_FILES['document']['tmp_name'], DIR_DOC . $name)) {
                throw new Exception(ConstantesGenericasUtil::MSG_ERR0_DOCUMENT, 404);
            }

            return $name;

        } catch (Exception $exception){
            throw new Exception(ConstantesGenericasUtil::MSG_ERR0_DOCUMENT, 404);
        }

    }

    public static function hasImage(){
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            return true;
        }
        else{
            return false;
        }
    }

    public static function hasDocument(){
        if(isset($_FILES['document']) && !empty($_FILES['document'])){
            return true;
        }
        else{
            return false;
        }
    }

    public static function updateGallery($codigo, $codGaleira)
    {

        try{
            $gallery = array();
            foreach ($_FILES as $key => $values) {
                if(str_contains($key, 'gallery')){
                    if($values['type'] === 'image/jpeg'){
                        $name = 'noticia' . $codigo . '-gallery' . $codGaleira . '.jpg';
                    }
                    else if($values['type'] === 'image/png'){
                        $name = 'noticia' . $codigo . '-gallery' . $codGaleira . 'png';
                    }
                    else{
                        throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE_TIPO, 404);
                    }
                    if (!move_uploaded_file($values['tmp_name'], DIR_IMG . $name)) {
                        throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE, 404);
                    } else {
                        $gallery[] = array("image" => $name, "cod_noticia" => $codigo);
                    }
                    $codGaleira++;
                }
            }
            return $gallery;
        } catch (Exception $exception){
            throw new Exception(ConstantesGenericasUtil::MSG_ERR0_IMAGE, 404);
        }

    }

    public static function deleteFile($file){
        $localFile = DIR_DOC . $file;
        if (file_exists($localFile) && !is_dir($localFile)){
            unlink($localFile);
        }
    }

}