
<div class="widget">
    <div class="content" ng-controller="Contatos" ng-model="Contatos">

        <table id="myTable" border="0" width="100" >
            <thead>
            <tr>

                <th class="header">Nome</th>

                <th class="header">Telefone</th>

                <th class="header">E-mail</th>

                <th class="header">Pós Atendimento</th>

                <th class="header">Meio</th>

                <th class="header">Atendente</th>

                <th colspan="3"></th>

            </tr>
            </thead>

            @include('modalLead')
            <tbody>
            @foreach($contatos as $contato)

                <tr class="">
                    <td class="nome">{!! $contato->nome !!}</td>
                    <td>({{$contato->ddd}}) {{$contato->telefone}}</td>
                    <td>{{$contato->email}}</td>
                    <td class="meio"><span class="vendido">{{$contato->pos_atendimento}}</span></td>
                    <td>{{$contato->insercao_hotmart}}</td>
                    <td>{{$contato->at_nome_atendente}}</td>
                    <td class="acao"><a href="{{route('admin.atender', $contato->id)}}" class="atender">Atender</a></td>
                    <td class="acao">
                        <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                    </td>
                    <td>
                        <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                           data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

</div>
