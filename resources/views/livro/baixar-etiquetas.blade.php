<div class="widget" style="min-height: 230px;">
    <div class="content">

        <form action="" name="enviarQueries" method="post">
        <table id="myTable" border="0" width="100">
            <thead>
            <tr>
                <th class="header">Data</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="header" colspan="2">Ações</th>
            </tr>
            </thead>
            <tbody>

                <?php
               foreach($scan as $contato):

                    if($contato == '.' || $contato == '..'){
                        continue;
                    }

                    $contato1 = substr($contato, 0, -21);
                    $contato1 = ucfirst($contato1);
                    $contato2 = substr($contato, 9,-4);

                ?>
                <tr class="odd">
                    <td style="font-size:20px;">{!! $contato2!!}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="{{route('admin.brindes.baixar_etiqueta',$contato)}}"><img src="/images/baixaretiqueta.svg" width="150" title="Baixar Etiqueta" alt="[Baixar]" class="icone" /></a></td>
                    <td><a href="{{route('admin.brindes.deletar_etiqueta',$contato)}}"><img src="/images/excluir.svg" title="Excluir" alt="[Excluir]" class="icone" width="30" /></a></td>

                </tr>
                </td>
                <?php endforeach;?>
            </tbody>

        </table>

        </form>

    </div>
</div>