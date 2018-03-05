<?php
/**
 * Created by PhpStorm.
 * User: mbr
 * Date: 26/02/2018
 * Time: 10:00
 */

namespace App\Helpers;

/**

* Gera uma linha de um documento com valores separados por vírgula

*/

class CSVLine {

    /**

     * Matriz que irá armazenar os dados das colunas

     * @var array

     */

    private $data = array();



    /**

     * Número de campos da linha

     * @var integer

     */

    private $fields = 0;



    /**

     * Constroi uma nova linha de valores separados por vírgula

     * @param mixed $arg1[optional] Um valor que será armazenado na linha

     * @param mixed $arg2[optional] Um valor que será armazenado na linha

     * @param mixed ... Um valor que será armazenado na linha

     * @param mixed $argn[optional] Um valor que será armazenado na linha

     */

    public function __construct( $arg1 , $arg2 , $argn ){

        $argv = func_get_args();

        $argc = count( $argv );



        for ( $i = 0 ; $i < $argc ; $i++ ){

            $this->addData( $argv[ $i ] );

        }

    }



    /**

     * Converte o objeto para sua representação em string

     * @return string

     */

    public function __toString(){

        return( implode( ";" , $this->data ) );

    }



    /**

     * Adiciona um novo valor à linha

     * @param mixed $value Um valor qualquer

     * @return CSVLine Referência ao próprio objeto

     */

    public function addData( $value ){

        if ( preg_match( "/(,|\r\n|\n|\"|')+/" , $value ) ){

            $value = preg_replace( "/\"+/" , "\"\"" , $value );

            $value = sprintf( "\"%s\"" , $value );

        }



        $this->data[] = $value;

        ++$this->fields;

    }



    /**

     * Conta o número de colunas que a linha possui

     * @return integer

     */

    public function count(){

        return( count( $this->data ) );

    }

}