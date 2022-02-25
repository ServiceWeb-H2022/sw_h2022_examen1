<?php

namespace App\Action\Titre;

use App\Domain\Titre\Service\TitreCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TitreCreateAction
{
    private $titreCreate;

    public function __construct(TitreCreate $titreCreate)
    {
        $this->titreCreate = $titreCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {


        $data = $request->getParsedBody();
        
        $titleId = $this->titreCreate->createTitle($data);

        $result = ["show_id" => $titleId];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}