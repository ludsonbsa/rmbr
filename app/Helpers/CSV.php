<?php
namespace App\Helpers;

/**
 * Gera um documento com valores separados por v�rgula
 */
class CSV {
    /**
     * Matriz que ir� armazenar todas as linhas do CSV
     * @var array
     */
    private $data = array();

    /**
     * N�mero de colunas
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
                throw new Exception( "O diret�rio n�o existe." );
            }
        }

        if ( file_exists( $file ) ){
            if ( !is_writable( $file ) ){
                throw new Exception( "O arquivo de destino n�o � grav�vel." );
            }
        }

        if ( ( $fh = fopen( $file , "w+" ) ) ){
            $csv = (string) $this;
            fwrite( $fh , $csv , strlen( $csv ) );
            fclose( $fh );
            $ret = true;
        } else {
            throw new Exception( "N�o foi poss�vel abrir/criar o arquivo para grava��o." );
        }

        return( $ret );
    }

    /**
     * Adiciona uma nova linha ao CSV
     * @param CSVLine $line A linha que ser� adicionada
     * @return CSV Refer�ncia ao pr�prio objeto
     */
    public function addLine( CSVLine $line ){
        if ( !count( $this->data ) ){
            $this->fields = $line->count();
        } elseif ( $this->fields != $line->count() ){
            throw new Exception( "Todas as linhas devem ter o mesmo n�mero de colunas" );
        }

        $this->data[] = $line;
        return( $this );
    }

    /**
     * Converte o objeto para sua representa��o em string
     * @return string
     */
    public function __toString(){
        return( implode( "\n" , $this->data ) );
    }
}
