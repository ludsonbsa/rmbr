<html ng-app="AlgoliaApp">
<head>
    <title>Angular</title>
    <link rel="stylesheet" href="<?php env('APP_URL');?>/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="<?php env('APP_URL');?>/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <style>
        .aa-input-container {
            display: inline-block;
            position: relative; }
        .aa-input-search {
            width: 300px;
            border: 1px solid rgba(228, 228, 228, 0.6);
            padding: 12px 28px 12px 12px;
            box-sizing: border-box;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none; }
        .aa-input-search::-webkit-search-decoration, .aa-input-search::-webkit-search-cancel-button, .aa-input-search::-webkit-search-results-button, .aa-input-search::-webkit-search-results-decoration {
            display: none; }
        .aa-input-icon {
            height: 16px;
            width: 16px;
            position: absolute;
            top: 50%;
            right: 16px;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            fill: #e4e4e4; }
        .aa-dropdown-menu {
            background-color: #fff;
            border: 1px solid rgba(228, 228, 228, 0.6);
            min-width: 300px;
            margin-top: 10px;
            box-sizing: border-box; }
        .aa-suggestion {
            padding: 12px;
            cursor: pointer;
        }
        .aa-suggestion + .aa-suggestion {
            border-top: 1px solid rgba(228, 228, 228, 0.6);
        }
        .aa-suggestion:hover, .aa-suggestion.aa-cursor {
            background-color: rgba(241, 241, 241, 0.35); }
    </style>
</head>
<body>

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
            <p ng-bind-html="hit._highlightResult.endereco.value"></p>
        </div>

    </div>
</div>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="<?php env('APP_URL');?>/js/algoliasearch.min.js"></script>
<script src="<?php env('APP_URL');?>/js/autocomplete.min.js"></script>
<script src="<?php env('APP_URL');?>/js/angular.min.js"></script>
<script src="<?php env('APP_URL');?>/js/angular-sanitize.min.js"></script>


<script>
    angular.module('AlgoliaApp', ['ngSanitize'])
        .factory('Contatos',function(){
            var algolia = algoliasearch('D4EIHRAU95', '44a22a5413aeb6e6c366eb92e132ce45');
            var index = algolia.initIndex('tb_contatos');
            index.search('', function(success, content){});

            return index;
        })
        .controller('Contatos',function($scope, Contatos){
            $scope.hits = [];
            $scope.query = '';
            $scope.initRun = true;
            $scope.search = function(){
                Contatos.search($scope.query, function(success, content){
                    $scope.hits = content.hits;
                });
            };
            $scope.search();
        });
</script>

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

</body>

<script src="<?php env('APP_URL');?>/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="<?php env('APP_URL');?>/js/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
</html>