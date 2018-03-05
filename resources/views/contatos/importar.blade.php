@extends(layout())

@section('content')

    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Importar base de dados<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>
        <div class="widget">

            @if(session()->has('msg'))
                <div class='alert alert-success'>
                {{ session('msg') }}
                </div>
                @elseif(session()->has('msg-error'))
                <div class='alert alert-danger'>
                    {{ session('msg-error') }}
                </div>
            @endif

            <div class="tabs-content">
                <div class="tabs-menu">
                    <ul>
                        <li><a class="active-tab-menu" href="#" data-tab="tab1">Base de Contatos</a></li>
                        <li><a href="#" data-tab="tab2">Recuperação de Vendas</a></li>
                    </ul>
                </div> <!-- tabs-menu -->


                <div class="tab1 tabs first-tab">

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

                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Select files...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="files" multiple>
                        </span>
                        <br>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <div id="files" class="files"></div>
                    </div>
                </div>
            <div id="loader"></div>

            <div class="tab2 tabs">
                <div class="field-wrap-c t94">
                    <form name="adminform2" action="" method="post" enctype="multipart/form-data" _lpchecked="1">
                        <?php echo csrf_field(); ?>
                        <div class="field-wrap t90">
                            <label for="recuperacao" class="icone" id="planilhaHotmart"><img src="/images/import_input.svg" width="70" />
                                <h3 style="font-size:20px; margin-top:20px; color:#a4a4a4">Comece importando um arquivo <strong>.csv</strong> de recuperação</h3>
                                <p style="color:#d2d2d2">Basta clicar aqui para fazer a busca no seu computador</p>

                                <p id="planilhaNomeRec"></p>
                            </label>
                            <input type="file" name="planilha2" id="recuperacao">
                        </div>

                        <div class="field-wrap t100">
                            <button type="submit" name="enviarPlanilhaRecup" class="button enviar t30">Importar Planilha</button>
                        </div>

                    </form>
                </div>
            </div> <!-- .tab2 -->

    </section>
    <link rel="stylesheet" href="{{env('APP_URL')}}/blueimp/jquery-file-upload/css/jquery.fileupload.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

@endsection
