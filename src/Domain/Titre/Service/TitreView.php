<?php

namespace App\Domain\Titre\Service;

use App\Domain\Titre\Repository\TitreViewRepository;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class TitreView
{
    /**
     * @var TitreViewRepository
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param TitreViewRepository $repository The repository
     */
    public function __construct(TitreViewRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Affiche un titre selon son id
     *
     * @return array Les informations du titre sélectionné
     */
    public function viewTitleById(int $id): array
    {
        $title = $this->repository->selectTitleById($id);

        if(!empty($title)) {
            $title['actors'] = explode(",", $title['actors']);
            $title['listed_in'] = explode(",", $title['listed_in']);
        }

        return $title;
    }

    /**
     *  Afficher une liste de titre filtrée par type de titre
     * 
     *  @param array $params La liste de paramètres de la requête
     * 
     *  @return array Un tableau formaté du résultat
     */
    public function viewFilteredTitle(array $params): array 
    {
        $acceptFilter = [
            'films' => 'Movie', 
            'series' => 'TV Show'];

        $filter = $acceptFilter[$params['filtre']] ?? ''; 
        $page = $params['page'] ?? 1;

        $titles = $this->repository->selectFilteredTitle($filter, $page);
        $nbPages = $this->repository->countTitle($filter);
        
        $resultat = [
            "titres" => $titles,
            "filter" => $filter,
            "page" => $page,
            "total_pages" => ceil($nbPages / $this->repository::NB_TITRE_PAR_PAGE)
        ] ;

        return $resultat;
    }

}
