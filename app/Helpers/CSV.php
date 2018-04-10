<?php
namespace App\Helpers;

/**
 *
 */
class CSV {
    /**

     * @var array
     */
    private $data = array();

    /**
     * Numero de colunas
     * @var integer
     */
    private $fields = 0;

    /**
     * Salva o arquivo em disco
     * @param string $file O nome do arquivo
     */
    public function save( $file ){
        $dir = dirname( $file );
        $ret = false;

        if ( !empty( $dir ) ){
            if ( !is_dir( $dir ) ){
                echo $dir;
                throw new \Exception("O diretório não existe.");
            }
        }

        if ( file_exists( $file ) ){
            if ( !is_writable( $file ) ){
                throw new \Exception( "O arquivo de destino não é gravável." );
            }
        }

        if ( ( $fh = fopen( $file , "w+" ) ) ){
            $csv = (string) $this;
            fwrite( $fh , $csv , strlen( $csv ) );
            fclose( $fh );
            $ret = true;
        } else {
            throw new \Exception("Não foi possivel abrir/criar o arquivo para gravação.");
        }

        return( $ret );
    }

    /**
     * Adiciona uma nova linha ao CSV
     * @param CSVLine $line A linha que sera adicionada
     * @return CSV Referencia ao proprio objeto
     */
    public function addLine( CSVLine $line ){
        if ( !count( $this->data ) ){
            $this->fields = $line->count();
        } elseif ( $this->fields != $line->count() ){
            throw new \Exception( "Todas as linhas devem ter o mesmo numero de colunas" );
        }

        $this->data[] = $line;
        return( $this );
    }

    /**

     * @return string
     */
    public function __toString(){
        return( implode( "\n" , $this->data ) );
    }
}
