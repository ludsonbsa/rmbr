@extends(layout())

@section('content')

    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Leads <a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

        <div class="tabs-content">

            <div class="tabs-menu">

                <ul>
                    <li><a class="active-tab-menu" href="1" data-tab="tab1">Atender Leads</a></li>
                    <li><a href="#2" data-tab="tab2">Vendidos Não Conferidos</a></li>
                    <li><a href="#3" data-tab="tab3">Não Vendidos</a></li>
                    <li><a href="#4" data-tab="tab4">Boletos Gerados</a></li>
                    <li><a href="#5" data-tab="tab5">Ligar Depois</a></li>
                    <li><a href="#7" data-tab="tab8">Agendado</a></li>
                    <li><a href="#6" data-tab="tab6">Recuperar Boletos</a></li>
                    <li><a href="#7" data-tab="tab7">Não Atendidos</a></li>

                </ul>
            </div> <!-- tabs-menu -->


            <div class="tab1 tabs first-tab">
                <div class="widget">
                    <div class="content" ng-controller="Contatos" ng-model="Contatos">

                        <table id="myTable" border="0" width="100" >
                            <thead>
                            <tr>

                                <th class="header">Nome</th>

                                <th class="header">Telefone</th>

                                <th class="header">E-mail</th>

                                <th class="header">Meio</th>

                                <th class="header">Prioridade</th>

                                <th class="header">Responsável</th>

                                <th colspan="2"></th>

                            </tr>
                            </thead>


                            <tbody>
                            @foreach($contatos as $contato)
                                <tr class="">
                                    <td class="nome">{{$contato->nome}}</td>
                                    <td>({{$contato->ddd}}){{$contato->telefone}}</td>
                                    <td>{{$contato->email}}</td>
                                    <td class="meio"><span>{{$contato->insercao_hotmart}}</span></td>
                                    <td>{{$contato->prioridade}}</td>
                                    <td>{{$contato->user_nome}}</td>
                                    <td class="acao"><a href="" class="atender">Atender</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <?php echo $contatos->links();?>
        </div>

        </div><!--container de header search -->
    </section>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="{{asset('js/algoliasearch.min.js')}}"></script>
    <script src="{{asset('js/autocomplete.min.js')}}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-sanitize.min.js')}}"></script>

    <script>
        angular.module('AlgoliaApp', ['ngSanitize'])
            .factory('Contatos',function(){
                var client = algoliasearch("D4EIHRAU95", "44a22a5413aeb6e6c366eb92e132ce45");
                var index = client.initIndex('tb_contatos');

                return index;
            })
            .controller('Contatos',function($scope){
                $scope.data = listar;
                $scope.query = '';
                $scope.initRun = true;

            });
    </script>
@endsection