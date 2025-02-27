<?php

namespace App\Repository;

use App\Entity\Estilo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Estilo>
 */
class EstiloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estilo::class);
    }

    //    /**
    //     * @return Estilo[] Returns an array of Estilo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function obtenerEstilosPorUsuario(): ?Estilo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nombre = :nombre')
            ->setMaxResults(1) // Asegura que solo se devuelva un resultado
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function buscarEstilo($nombre): ?Estilo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nombre = :nombre')
            ->setParameter('nombre', $nombre)
            ->setMaxResults(1) // Asegura que solo se devuelva un resultado
            ->getQuery()
            ->getOneOrNullResult();
    }
}
