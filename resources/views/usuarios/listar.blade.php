@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
    <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Usuários <a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

    <div class="tabs-content">

        <div class="tabs-menu">

            <ul>
                <li><a class="active-tab-menu" href="#1" data-tab="tab1-user">Listagem</a></li>
                <li><a href="#2" data-tab="tab2-user">Adicionar Usuário</a></li>
            </ul>

        </div> <!-- tabs-menu -->

        <div class="tab1 tabs first-tab">
            <div class="widget">

            <table id="myTable" border="0" width="100">

                <thead>

                <tr>

                    <th class="header">Nome</th>

                    <th class="header">Nível</th>

                    <th class="header">Status</th>

                    <th colspan="3" class="header">Ações</th>

                </tr>

                </thead>

                <tbody>

                @foreach($usuarios as $user)

                    <?php

                    if($user->status == 1 ){

                        $status = "Ativo";

                        $get = 'desativar';

                        $button = 'desabilitar';

                        $classe = 'ativado';

                    }else if($user->status == 0){

                        $status = "Inativo";

                        $get = 'ativar';

                        $button = 'habilitar';

                        $classe = 'desativado';

                    }

                    ?>

                <tr class="odd">

                    <td class="nome"><img src="{!!$user->avatar!!}" width="40" height="40" class="atendente perfilEdit"><span class="comis">{!!$user->user_nome!!}</span></td>

                    <td>{!! $user->role_name !!}</td>

                    <?php ($user->status == 1 ? $status = 'Ativado' : $status = 'Desativado'); ?>

                    <td>{!! $status !!}</td>

                    <td><a href="{{route('admin.editar.usuario', $user->id)}}"><img src="/images/editar.svg" width="30" class="icone"/></a></td>


                    <td>
                        <a href="{{route('admin.status', [$classe, $user->id])}}" title="{{ucfirst($status)}}">
                            <div class="{{$classe}}"></div>
                        </a>
                    </td>

                    <td>
                        <a href="{{route('admin.excluir', $user->id)}}"><img src="/images/excluir.svg" width="33" class="icone" title="Excluir" /></a>
                    </td>

                </tr>
                    @endforeach
                </tbody>
            </table>

          </div>
        </div>
    </div>
</section>
@endsection