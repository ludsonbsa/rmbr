<?php

namespace App\Helpers;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Uploader
{
    protected $destinoFinal;
    protected $arquivo;
    protected $nome_temporario;
    protected $destino;
    protected $ext;
    protected $random;


    public function setDestino($destino)
    {
        if(!is_dir($destino)){
            mkdir($destino);
            mkdir($destino.'/'.date('Y'));
            mkdir($destino.'/'.date('Y').'/'.date('m'));
            $this->destino = $destino.'/'.date('Y').'/'.date('m').'/';
        }elseif(is_dir($destino)){
            mkdir($destino.'/'.date('Y').'/'.date('m'));
            $this->destino = $destino.'/'.date('Y').'/'.date('m').'/';
        }
    }

    public function setDestinoRec()
    {
        $this->destino = 'planilhas/recuperacao/';
    }

    public function setDestinoAvatar()
    {
        $this->destino = 'avatar/';
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function randomize(){
        $this->destinoFinal = $this->getDestino().'/'.$this->getArquivo();
        $explode = explode(".", $this->getArquivo());
        $this->ext = end($explode);
        $this->setArquivo(md5(rand(1,50).$this->destinoFinal).".".$this->ext);
        return $this;
    }

    public function getDestinoFinal(){
        return $this->destinoFinal;
    }

    public function uploader(){
        try{
            if(!empty($this->getArquivo())){
                $this->randomize();
                move_uploaded_file($this->getNomeTemporario(), $this->getDestino().$this->getArquivo());
            }else{
                //echo "Vazio";
            }

        }catch (FileNotFoundException $e){
            echo $e;
        }
    }

    public function uploadAvatar(){
        try{
            //$this->randomize();
            move_uploaded_file($this->getNomeTemporario(), $this->getDestino().$this->getArquivo());
        }catch (FileNotFoundException $e){
            echo $e;
        }
    }

    public function uploader2(){
        try{
            //$this->randomize();
            move_uploaded_file($this->getNomeTemporario(), $this->getDestino().$this->getArquivo());
        }catch (FileNotFoundException $e){
            echo $e;
        }
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    /**
     * @return mixed
     */
    public function getNomeTemporario()
    {
        return $this->nome_temporario;
    }

    /**
     * @param mixed $nome_temporario
     */
    public function setNomeTemporario($nome_temporario)
    {
        $this->nome_temporario = $nome_temporario;
    }



}