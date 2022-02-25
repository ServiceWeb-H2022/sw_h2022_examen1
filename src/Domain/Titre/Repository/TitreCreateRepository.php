<?php

namespace App\Domain\Titre\Repository;

use PDO;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Repository.
 */
class TitreCreateRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection, LoggerFactory $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger
            ->addFileHandler('Transaction.log')
            ->createLogger("TitreCreateRepository");
    }

    /**
     * Création d'un nouveau titre.
     *
     * @param array $book Les informations du titre à créer
     *
     * @return int Le id du titre créé
     */
    public function insertTitle(array $data): int
    {
        $params = [
            "show_type" => $data['show_type'],
            "title" => $data['title'],
            "director" => $data['director'],
            "actors" => $data['actors'],
            "country"=> $data['country'],
            "date_added" => $data['date_added'],
            "release_year" => $data['release_year'],
            "rating" => $data['rating'],
            "duration" => $data['duration'],
            "listed_in" => $data['listed_in'],
            "description" => $data['description']
        ];

        $sql = "INSERT INTO netflix_titles (
                    show_type, 
                    title, 
                    director, 
                    actors, 
                    country, 
                    date_added, 
                    release_year, 
                    rating, 
                    duration, 
                    listed_in, 
                    `description`) 
                VALUES (
                    :show_type, 
                    :title, 
                    :director, 
                    :actors, 
                    :country, 
                    :date_added, 
                    :release_year, 
                    :rating, 
                    :duration, 
                    :listed_in, 
                    :description);";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $titleId = (int)$this->connection->lastInsertId();

        $errorInfo = $query->errorInfo();
        if($errorInfo[0] != 0) {
            $this->logger->error($errorInfo[2]);
            $titleId = 0;
        } else {
            $this->logger->info("Ajout du titre [{$data['title']}] id : $titleId");
        }

        return $titleId;
    }
}

