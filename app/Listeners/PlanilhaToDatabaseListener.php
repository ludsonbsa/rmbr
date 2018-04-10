<?php

namespace App\Listeners;

use App\Events\PlanilhaImportada;
use Illuminate\Database\QueryException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class PlanilhaToDatabaseListener
{
    /**
     * Handle the event.
     *
     * @param  PlanilhaImportada  $event
     * @return void
     */
    public function handle(PlanilhaImportada $event)
    {
        $import = $event->getImport();


       /* # Ler as linhas separadas por ; somente as verdadeiras ou existentes
        while (($datas = fgetcsv($handle1, 1000, ";")) !== FALSE) {

            if (!empty($datas[18]) && $datas[21]) {

                #Atribui os campos de e-mail e status as variáveis
                $status = $datas[18];
                $email = $datas[21];

                try {
                    $results = DB::table('tb_contatos')
                        ->whereRaw("email = '{$email}' AND (status != 'Aprovado' OR status != 'Completo') AND (pos_atendimento IS NULL) AND completo = 0")->get();

                    foreach ($results as $v):
                        $dad = [
                            'status' => $status
                        ];
                        //ler se existe, em caso afirmativo faz o update
                        $query =
                            DB::table('tb_contatos')
                                ->where('email', $email)
                                ->update($dad);
                    endforeach;

                } catch (QueryException $e) {
                    echo $e->getMessage();
                }
            }
        }
        $executionEndTime = microtime(true);
        //$seconds = $executionEndTime - $executionStartTime;
        //\Log::info("Atribuir Dados do Contato {$seconds}");

        fclose($handle1);

        #Executa query que insere os dados de planilha no banco de dados
        //Event::dispatch($this->queryHotmart(Auth::id()));
        #Verifica Aprovados
        // Event::dispatch($this->aprovados());
        //$this->aprovados();
        #verifica Pos-atendimento
        //$this->verificapa();*/


    }
}
