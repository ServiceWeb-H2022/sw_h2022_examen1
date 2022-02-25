<?php

namespace App\Action\Titre;

use App\Domain\Titre\Service\TitreView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TitreViewAction
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


        $titleId = $request->getAttribute('id', 0);
        
        $result = $this->titreView->viewTitleById($titleId);

        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}