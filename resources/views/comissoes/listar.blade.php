@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Comissões<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

        <div class="tabs-content">
            <div class="tabs-menu">
                <ul>
                    <li><a class="active-tab-menu" href="#" data-tab="tab1">Conferir Vendas</a></li>
                    <li><a href="#" data-tab="tab2">Vendas Conferidas</a></li>
                    <li><a href="#" data-tab="tab3">Aprovar Manualmente</a></li>
                    <li><a href="#" data-tab="tab4">Comissionar Pendentes</a></li>
                    <li><a href="#" data-tab="tab5">Comissões Geradas</a></li>
                </ul>
            </div> <!-- tabs-menu -->


            <div class="tab1 tabs first-tab">

                <table id="myTable" border="0" width="100">
                    <thead>
                    <tr>
                        <th class="header">Nome</th>
                        <th class="header">Telefone</th>
                        <th class="header">Meio de Inserção</th>
                        <th class="header">E-mail</th>
                    </tr>
                    </thead>
                    <tbody>

                    <form action="" name="enviarQueries" method="post">
                        @foreach($contatos as $contato)
                        <tr class="odd">

                            <td class="nome">{{$contato->nome}}</td>
                            <td>{{$contato->ddd}} {{$contato->telefone}}</td>
                            <td>{{$contato->insercao_hotmart}}</td>
                            <td>{{$contato->email}}</td>

                            <input type="hidden" name="cpf" value="{{$contato->documento_usuario}}">
                            <input type="hidden" name="telefone" value="{{$contato->telefone}}">
                            <input type="hidden" name="email" value="{{$contato->email}}">
                        </tr>
                            @endforeach

                    </tbody>
                </table>
                <?php echo $contatos->links() ?>
                <div class="field-wrap" style="float:right; margin-top:0px; padding:17px; width:96.75%;">
                    <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px;">Você precisa conferir {{$count}} vendas</h3>

                    <button type="submit" name="enviarQueryConferencia1" class="enviar">Conferir Vendas</button>
                </div>
                </form>

            </div>

            <div id="loader"></div>
            <div class="tab2 tabs">
                    <div>TESTE</div>
            </div> <!-- .tab2 -->

            <div class="tab3 tabs">
TESTE
            </div> <!-- .tab3 -->

            <div class="tab4 tabs">
                <
            </div> <!-- .tab4 -->

            <div class="tab5 tabs">

            </div> <!-- .tab5 -->


        </div>
    </section>
@endsection