@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

    <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Dashboard<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

    <div class="tabs-content">

        <div class="tabs-menu">

            <ul>

                <li><a class="active-tab-menu" href="#" data-tab="tab1">Visão Geral</a></li>

                <li><a href="#" data-tab="tab2">Ligações</a></li>

                <!--<li><a href="#" data-tab="tab3">Vendas</a></li>

                <li><a href="#" data-tab="tab4">Comissionar Pendentes</a></li>

                <li><a href="#" data-tab="tab5">Comissões Geradas</a></li> -->

            </ul>

        </div> <!-- tabs-menu -->



        <?php
        ?>


        <div class="tab1 tabs first-tab">

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawVisualization);

                function drawVisualization() {
                    // Some raw data (not necessarily accurate)
                    var data = google.visualization.arrayToDataTable([
                        ['Dia/Mês', 'Ligações'],
                        ['Dia '+'' ]
                    ]);

                    var options = {
                        title : 'Ligações por Dia',
                        vAxis: {title: 'Quantidade'},
                        hAxis: {title: ''},
                        seriesType: 'bars',
                        series: {5: {type: 'line'}},
                        colors: ['#ff0000']
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>

            <div class="t96 dashinfo2">
                <div id="chart_div" class="t96"></div>
            </div>

            <br><br>

            <div class="t17 dashinfo">
                <h2>TOTAL DE LEADS</h2>
                <p></p>
            </div>


            <div class="t17 dashinfo">
                <h2>LIGAÇÕES PARA FAZER</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>TOTAL DE LIGAÇÔES FEITAS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LIGAÇÕES NÃO ATENDIDAS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LIGAÇÕES ATENDIDAS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>BOLETOS NÃO ATENDIDOS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>PARA LIGAR DEPOIS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>NÃO VENDIDOS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>VENDIDOS NÃO CONFERIDOS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>BOLETOS NÃO CONFERIDOS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>BRINDES A CONFERIR</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>ETIQUETAS A GERAR</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>ETIQUETAS GERADAS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>VENDAS PARA COMISSIONAR</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>VENDAS COMISSIONADAS</h2>
                <p></p>
            </div>


            <div class="t17 dashinfo">
                <h2>LEADS DE WHATSAPP</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LEADS DE WHATSAPP VENDIDOS</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LEADS DE CHAT</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LEADS VENDIDOS DE CHAT</h2>
                <p></p>
            </div>

            <div class="t17 dashinfo">
                <h2>LEADS DE PÁGINA DE CAPTURA</h2>
                <p></p>
            </div>


            <div class="t96 dashinfo">
                <p class="valor" style="margin-top:33px;">R$ <span>vendidos</span></p>
            </div>

        </div>

        <div id="loader"></div>

        <div class="tab2 tabs">

        </div> <!-- .tab2 -->


        <div class="tab3 tabs">

        </div> <!-- .tab3 -->

</section>
@endsection

