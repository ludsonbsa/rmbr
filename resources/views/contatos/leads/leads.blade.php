@extends(layout())

@section('content')

    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        @if(session()->has('msg'))
            <div class='alert alert-success'>
                {{ session('msg') }}
            </div>
        @elseif(session()->has('msg-error'))
            <div class='alert alert-danger'>
                {{ session('msg-error') }}
            </div>
        @endif

        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Leads <a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

        <div class="tabs-content">

            <div class="tabs-menu">

                <ul>
                    <li><a class="active-tab-menu" href="#1" data-tab="lead-tab1">Atender Leads</a></li>
                    <li><a href="#7" data-tab="lead-tab7">Recuperar Boletos</a></li>
                    <li><a href="#2" data-tab="lead-tab2">Vendidos Não Conferidos</a></li>
                    <li><a href="#3" data-tab="lead-tab3">Não Vendidos</a></li>
                    <li><a href="#4" data-tab="lead-tab4">Boletos Gerados</a></li>
                    <li><a href="#5" data-tab="lead-tab5">Ligar Depois</a></li>
                   <!-- <li><a href="#6" data-tab="lead-tab6">Agendado</a></li> -->
                    <li><a href="#8" data-tab="lead-tab8">Não Atendidos</a></li>

                </ul>
            </div> <!-- tabs-menu -->


            <div class="tab1 tabs first-tab">
                <div class="widget">
                    <div class="content" ng-controller="Contatos" ng-model="Contatos">

                        <table id="myTable" border="0" width="100" >
                            <thead>
                            <tr>
                                <th class="header">Nome</th>

                               <!-- <th class="header">Telefone</th> -->

                                <th class="header">E-mail</th>

                                <th class="header">Meio</th>

                                <th class="header">Prioridade</th>

                                <th class="header">Produto</th>

                                <th class="header">Responsável</th>

                                <th colspan="3"></th>

                            </tr>
                            </thead>

                            @include('modalLead')
                            <tbody>
                            @foreach($contatos as $contato)

                                <tr class="" @if($contato->em_atendimento != 0 || $contato->em_atendimento != NULL) style="background:#e4e4e4; color:#ccc" disabled="" @endif @if($contato->em_atendendo != NULL) title="{!! $contato->em_atendendo !!} está atendendo" @endif>
                                <td class="nome">{!! $contato->nome !!}</td>
                                <!--<td>({{$contato->ddd}}) {{$contato->telefone}}</td>-->
                                    <td>{{$contato->email}}</td>
                                    <td class="meio"><span>{{$contato->insercao_hotmart}}</span></td>
                                    <td>{!!$contato->prioridade!!}</td>

                                    <td @if($contato->nome_do_produto == "Programa Mulheres Bem Resolvidas") style="" @endif>{!!$contato->nome_do_produto !!}</td>
                                    <td>{!! $contato->user_nome !!}</td>

                                    <!-- admin -->
                                    @if(Auth::user()->role == 1)
                                        <td class="acao"><a href="{{route('admin.atender', $contato->id)}}" class="atender">Atender</a></td>
                                        <td class="acao">
                                            <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                        </td>
                                        <td>
                                            <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                                               data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                        </td>
                                    @endif

                                <!-- RESPONSAVEL -->

                                    @if(Auth::user()->role == 2)
                                        @if($contato->em_atendimento == \Auth::user()->id OR $contato->em_atendimento == NULL)
                                            <td class="acao">
                                            </td>
                                            @else
                                            <td style="color:red;">Em atendimento</td>
                                        @endif

                                        @if($contato->id_responsavel == \Auth::user()->id)

                                                <td class="acao">
                                                    <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                                </td>

                                                <td>
                                                    <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                                                       data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                                </td>
                                            @else
                                                <td></td>
                                        @endif
                                    @endif

                                <!-- ATENDENTE -->
                                    @if(Auth::user()->role == 3 || Auth::user()->role == 5)
                                        @if($contato->em_atendimento == \Auth::user()->id OR $contato->em_atendimento == NULL)
                                            <td class="acao"><a href="{{route('admin.atender', $contato->id)}}" class="atender">Atender</a></td>

                                            @else
                                            <td style='color:red'><strong>Em atendimento... </strong></td>
                                        @endif
                                        @if($contato->id_responsavel == \Auth::user()->id)
                                                <td class="acao">
                                                    <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                                </td>
                                            <td>
                                                <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                                                   data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                            </td>
                                            @else
                                            <td></td>
                                                <td></td>
                                        @endif
                                    @endif


                                <!-- SUPORTE -->
                                    @if(Auth::user()->role == 4)
                                        @if($contato->em_atendimento == \Auth::user()->id OR $contato->em_atendimento == NULL)
                                            <td class="acao">
                                            </td>
                                        @else
                                            <td style="color:red;">Em atendimento</td>
                                        @endif

                                        @if($contato->id_responsavel == \Auth::user()->id)
                                            <td class="acao">
                                                <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                            </td>

                                            <td>
                                                <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                                                   data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                            </td>
                                        @else
                                            <td></td>
                                                <td></td>
                                        @endif
                                    @endif

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $contatos->links() !!}
            </div>
        </div>


    </div>

    </div><!--container de header search -->
</section>

@endsection