<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        
        $result = json_encode([
            'message' => 'Bon examen à tous!!'
        ]);
        
        $response->getBody()->write($result);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        
    }
}
