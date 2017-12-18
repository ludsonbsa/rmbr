
<section class="user">
    <a href="/admin/dashboard/"><img src="/images/logo_mbr_digital.svg" width="200" style="position:absolute;"></a>
    <!--<div class="profile-img">
<p><img src="https://mbr.digital/public/assets/admin/images/uiface2.png" alt="" height="40" width="40" /> Bem-vindo  Ludson Almeida </p>
</div>-->

    <div class="buttons">
        <form name="busca" action="/admin/contatos/buscar/" method="get">
            <input type="search" name="busca" placeholder="Digite o e-mail, nome ou telefone para buscar um contato">
        </form>
    </div>

    <div class="buttons">
        <ul><!-- Atendente -->
            <a href="/admin/contatos/add/" title="MBR Follow Up - Adicionar Lead" alt="[Adicionar Lead]">
                <li><img src="/images/leads/new_lead.svg" width="20" class="icone" title="MBR Follow Up - Adicionar Lead" alt="[Adicionar Lead]"></li>
            </a>

            <a href="/admin/importar/" title="MBR Follow Up - Importar" alt="[Importar]">
                <li><img src="/images/leads/upload.svg" width="20" class="icone" title="MBR Follow Up - Importar Planilha" alt="[Importar Planilha]"></li>
            </a>


            <a href="#" title="MBR Follow Up - Notificações" alt="[Notificações]">

                <li><img src="/images/leads/ajuda.svg" width="20" class="icone" title="MBR Follow Up - Notificações" alt="[Notificações]">
                </li>
            </a>

            <a href="/admin/profile/" style="color:#333" class="userperfil" title="Ver Perfil"><li>
                    <div class="foto">{{ Auth::user()->name }}</div>
                    <span>{{ Auth::user()->role_name }}</span>
                    <img src="{{ Auth::user()->avatar }}" width="40" height="40" class="atendente perfilEdit">

                </li></a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a href="{{ route('admin.logout') }}" title="MBR Follow Up - Logout" alt="[Logout]" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><li><img src="/images/leads/logout.svg" width="20" class="icone"></li></a>

        </ul>
    </div>
</section>


