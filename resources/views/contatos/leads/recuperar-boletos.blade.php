<div class="widget">
    <div class="content">

        <table id="myTable" border="0" width="100" >
            <thead>
            <tr>

                <th class="header">Nome</th>

           <!--     <th class="header">Telefone</th> -->

                <th class="header">E-mail</th>

                <th class="header">Meio</th>

                <th class="header">Prioridade</th>

                <th class="header">Responsável</th>

                <th colspan="4"></th>

            </tr>
            </thead>

            @include('modalLead')
            <tbody>
            @foreach($contatos as $contato)

         <tr class="" @if($contato->em_atendimento != 0 || $contato->em_atendimento != NULL) style="background:#e4e4e4; color:#ccc" disabled="" @endif>
                   <td class="nome">{!! $contato->nome !!}</td>
                   <!--<td>({{$contato->ddd}}) {{$contato->telefone}}</td>-->
                       <td>{{$contato->email}}</td>
                       <td class="meio"><span>{{$contato->insercao_hotmart}}</span></td>
                       <td>{!!$contato->prioridade!!}</td>


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

                           @if($contato->em_atendendo != NULL || $contato->em_atendendo != '')
                               <td><img src="{{$contato->em_atendendo}}" alt="" width="30" class="atendente perfilEdit"></td>
                               @else
                               <td></td>
                           @endif

                       @endif

                   <!-- RESPONSAVEL -->

                       @if(Auth::user()->role == 2)
                           @if($contato->em_atendimento == \Auth::user()->id OR $contato->em_atendimento == NULL)
                               <td class="acao">
                               </td>
                               @else
                               <td><img src="{{$contato->em_atendendo}}" alt="" width="30" class="atendente perfilEdit" style="margin-left:20px;"></td>
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
                               <td ><img src="{{$contato->em_atendendo}}" alt="" width="30" class="atendente perfilEdit" style="margin-left:20px;"></td>
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
                               <td><img src="{{$contato->em_atendendo}}" alt="" width="30" class="atendente perfilEdit" style="margin-left:20px;"></td>
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
</div>
