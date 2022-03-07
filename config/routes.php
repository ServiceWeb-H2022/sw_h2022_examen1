<?php

use Slim\App;

return function (App $app) {


    $app->get('/', \App\Action\HomeAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Question #1 - Afficher un titre selon son id
    $app->get('/titres/{id}', \App\Action\Titre\TitreViewAction::class);
    // Question #2 - Ajouter un titre
    $app->post('/titres', \App\Action\Titre\TitreCreateAction::class);
    // Questioni #3 - Afficher une liste de films ou de séries
    $app->get('/titres', \App\Action\Titre\TitreViewWithFilterAction::class);


};

