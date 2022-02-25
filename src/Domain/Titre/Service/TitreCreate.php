<?php

namespace App\Domain\Titre\Service;

use App\Domain\Titre\Repository\TitreCreateRepository;

/**
 * Service.
 */
final class TitreCreate
{
    /**
     * @var TitreCreateRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param TitreCreateRepository $repository The repository
     */
    public function __construct(TitreCreateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Insère un nouveau titre.
     *
     * @param array $data Les informations du nouveau titre
     *
     * @return int Le id du titre créé
     */
    public function createTitle(array $data): int
    {
        $titreId = $this->repository->insertTitle($data);

        return $titreId;
    }

}
