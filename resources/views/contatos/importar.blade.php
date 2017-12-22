@extends(layout())

@section('content')
    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Importar base de dados<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>
        <div class="widget">

            <div class="tabs-content">
                <div class="tabs-menu">
                    <ul>
                        <li><a class="active-tab-menu" href="#" data-tab="tab1">Base de Contatos</a></li>
                        <li><a href="#" data-tab="tab2">Recuperação de Vendas</a></li>
                    </ul>
                </div> <!-- tabs-menu -->


                <div class="tab1 tabs first-tab">

                    <div class="field-wrap-c t94">
                        <form name="adminform" action="" method="post" enctype="multipart/form-data" _lpchecked="1">
                            <div class="field-wrap t90">
                                <label for="hotmart" id="planilhaHotmart" class="icone"><img src="/images/import_input.svg" width="70" />
                                    <h3 style="font-size:20px; margin-top:20px; color:#a4a4a4">Comece importando um arquivo <strong>.csv de base de dados</strong></h3>
                                    <p style="color:#d2d2d2">Basta clicar aqui para fazer a busca no seu computador</p>

                                    <p id="planilhaNome"></p>
                                </label>
                                <input type="file" id="hotmart" name="planilha">


                                <!--<progress value="0" max="100"></progress><span id="porcentagem">0%</span> -->


                            </div>
                    </div>

                    <div class="field-wrap t100">
                        <button type="submit" name="enviarPlanilhaConfig" class="button enviar t30">Importar Planilha</button>
                    </div>
                    </form>
                </div>
            </div>

            <div id="loader"></div>


            <div class="tab2 tabs">
                <div class="field-wrap-c t94">
                    <form name="adminform" action="" method="post" enctype="multipart/form-data" _lpchecked="1">
                        <div class="field-wrap t90">
                            <label for="recuperacao" class="icone" id="planilhaHotmart"><img src="/images/import_input.svg" width="70" />
                                <h3 style="font-size:20px; margin-top:20px; color:#a4a4a4">Comece importando um arquivo <strong>.csv</strong> de recuperação</h3>
                                <p style="color:#d2d2d2">Basta clicar aqui para fazer a busca no seu computador</p>

                                <p id="planilhaNomeRec"></p>
                            </label>
                            <input type="file" name="planilha" id="recuperacao">
                        </div>

                        <div class="field-wrap t100">
                            <button type="submit" name="enviarPlanilhaRecup" class="button enviar t30">Importar Planilha</button>
                        </div>

                    </form>
                </div>
            </div> <!-- .tab2 -->

    </section>
@endsection
