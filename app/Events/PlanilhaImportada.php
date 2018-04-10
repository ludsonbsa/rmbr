<?php

namespace App\Events;

use App\Importacoes;


class PlanilhaImportada
{
    private $import;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Importacoes $import)
    {
        $this->import = $import;
    }


    public function getImport()
    {
        return $this->import;
    }



}
