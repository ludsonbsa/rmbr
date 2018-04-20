@extends(layout())

@section('content')

    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Importar base de dados<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>
        <div class="widget">

            @if(session()->has('msg'))
                <div class='alert alert-success'>
                    {!! session('msg') !!}
                </div>
            @elseif(session()->has('msg-error'))
                <div class='alert alert-danger'>
                    {!! session('msg-error') !!}
                </div>
            @endif

            <div class="tabs-content">
                <div class="tabs-menu">
                    <ul>
                        <li><a class="active-tab-menu" href="#1" data-tab="tab1-imp">Base de Contatos</a></li>
                        <li><a href="#2" data-tab="tab2-imp">Recuperação de Vendas</a></li>
                    </ul>
                </div> <!-- tabs-menu -->


                <div class="tab1 tabs first-tab">
                    <div class="widget">

                        <div class="field-wrap-c t94">
                           <form name="adminform" action="{{route('admin.importar.upload')}}" method="post" enctype="multipart/form-data">

                                <?php echo csrf_field(); ?>
                                <div class="field-wrap t90">
                                    <label for="hotmart" id="planilhaHotmart" class="icone"><img src="/images/import_input.svg" width="70" />
                                        <h3 style="font-size:20px; margin-top:20px; color:#a4a4a4">Comece importando um arquivo <strong>.csv de base de dados</strong></h3>
                                        <p style="color:#d2d2d2">Basta clicar aqui para fazer a busca no seu computador</p>

                                        <p id="planilhaNome"></p>
                                    </label>
                                    <input type="file" id="hotmart" name="planilha" />
                                </div>

                                <div class="field-wrap t100">
                                    <button type="submit" name="enviarPlanilhaConfig" class="button enviar t30">Importar Planilha</button>
                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
    <link rel="stylesheet" href="{{env('APP_URL')}}/blueimp/jquery-file-upload/css/jquery.fileupload.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

@endsection
