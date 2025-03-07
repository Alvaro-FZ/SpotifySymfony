<?php

namespace App\Repository;

use App\Entity\Playlist;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    //    /**
    //     * @return Playlist[] Returns an array of Playlist objects
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

    public function findByNombre(string $query): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.nombre LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    /* public function findPlaylistsPublicas(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.nombre LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    } */

    public function obtenerLikesPlaylist(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.nombre AS playlist, SUM(p.likes) AS likes')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function buscarPlaylist($nombre): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :nombre')
            ->setParameter('nombre', $nombre)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // src/Repository/PlaylistRepository.php
    public function findByUsuarioPropietarioId($usuarioId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.usuarioPropietario = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->getQuery()
            ->getResult();
    }
}
