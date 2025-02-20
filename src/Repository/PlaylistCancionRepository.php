<?php

namespace App\Repository;

use App\Entity\PlaylistCancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlaylistCancion>
 */
class PlaylistCancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistCancion::class);
    }

    //    /**
    //     * @return PlaylistCancion[] Returns an array of PlaylistCancion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PlaylistCancion
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function obtenerReproduccionesPorPlaylist(): array
    {
        return $this->createQueryBuilder('pc')
            ->select('p.nombre AS playlist, SUM(pc.reproducciones) AS totalReproducciones')
            ->join('pc.playlist', 'p')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function findCancionesByPlaylist(int $playlistId): array
    {
        return $this->createQueryBuilder('pc')
            ->join('pc.cancion', 'c') // "pc.cancion" debe coincidir con la relación en PlaylistCancion
            ->addSelect('c') // Selecciona los datos de la canción
            ->where('pc.playlist = :playlistId') // "pc.playlist" debe coincidir con la relación en PlaylistCancion
            ->setParameter('playlistId', $playlistId)
            ->getQuery()
            ->getResult();
    }
}
