<?php

namespace App\Domain\Titre\Repository;

use PDO;

/**
 * Repository.
 */
class TitreViewRepository
{
    const NB_TITRE_PAR_PAGE = 20;

    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sélectionne tous les titres de la page selon un type de titre
     * 
     * @param string $filter Le type de titre à sélectionner
     * @param int $noPage Le numéro de la page à sélectionner
     * 
     * @return array La liste des titres sélectionnés
     */
    public function selectFilteredTitle(string $filter, int $noPage = 1): array
    {
        $offset = ($noPage - 1) * self::NB_TITRE_PAR_PAGE;
        $showTypeFilter = !empty($filter) ? "WHERE show_type ='$filter'" : "";

        $sql = "SELECT show_id, title FROM netflix_titles $showTypeFilter LIMIT :nbRecord OFFSET :offset ;";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':nbRecord', (int)self::NB_TITRE_PAR_PAGE, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne un titre selon son id
     * 
     * @param int $id Le id du titre à sélectionner
     * 
     * @return array Les informations du titre sélectionné
     */
    public function selectTitleById(int $id): array
    {
        $params = [
                    'id' => $id,
                ];

        $sql = "select * from netflix_titles where show_id = :id;";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $result = !$result ? [] : $result;

        return $result;
    }

    /**
     * Le nombre de titres total selon un filtre sur le type de titre
     * 
     * @param string $filter Le type de titre à sélectionner
     * 
     * @return int Le nombre de titre
     */
    public function countTitle(string $filter): int
    {
        
        $showTypeFilter = !empty($filter) ? "WHERE show_type ='$filter'" : "";
        $sql = "SELECT count(*) as nbTitle FROM netflix_titles $showTypeFilter;";

        $stmt = $this->connection->query($sql);
        $result = $stmt->fetch();

        return (int)$result['nbTitle'] ?? 0;
    }


}

