@extends(layout())

@section('content')
<div class="container" ng-controller="Contatos">
    <h1>Contatos</h1>


    <form action="/" method="get">
        Search:
        <input type="search" id="aa-search-input"
               class="aa-input-search form-control" placeholder="Pesquisar" name="str" autocomplete="off" spellcheck="false" ng-keyup="search()" ng-model="query" />
    </form>

    <div class="hit" ng-repeat="hit in hits">
        <div class="col-md-3" style="border:1px solid #ccc; margin: 10px; min-height:275px; float:left;">
            <h3 ng-bind-html="hit._highlightResult.nome.value"></h3>
            <p ng-bind-html="hit._highlightResult.email.value"></p>
            <p>CPF: <span ng-bind-html="hit._highlightResult.documento_usuario.value"></span></p>
            <p ng-bind-html="hit._highlightResult.endereco.value"></p>
            <p ng-bind-html="hit._highlightResult.cep.value"></p>
            Aprovado: <p ng-bind-html="hit._highlightResult.data_ligar_depois.value"></p>
        </div>

    </div>
</div>



<!-- Initialize autocomplete menu

<script>
    var client = algoliasearch("D4EIHRAU95", "44a22a5413aeb6e6c366eb92e132ce45");
    var index = client.initIndex('courses');
    //initialize autocomplete on search input (ID selector must match)
    autocomplete('#aa-search-input',
        { hint: false }, {
            source: autocomplete.sources.hits(index, {hitsPerPage: 5}),
            //value to be displayed in input control after user's suggestion selection
            displayKey: 'name',
            //hash of templates used when rendering dataset
            templates: {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function(suggestion) {
                    return '<span>' +
                        suggestion._highlightResult.name.value + '</span><span>' +
                        suggestion._highlightResult.name.value + '</span>';
                }
            }
        });
</script>-->
@endsection