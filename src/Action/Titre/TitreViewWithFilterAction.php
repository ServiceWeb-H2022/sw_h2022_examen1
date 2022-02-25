<?php

namespace App\Action\Titre;

use App\Domain\Titre\Service\TitreView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TitreViewWithFilterAction
{
    private $titreView;

    public function __construct(TitreView $titreView)
    {
        $this->titreView = $titreView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
         

        $params = $request->getQueryParams() ?? [];
        
        $resutlat = $this->titreView->viewFilteredTitle($params);


        $response->getBody()->write((string)json_encode($resutlat));

        return $response->withHeader('Content-Type', 'application/json');
    }
}