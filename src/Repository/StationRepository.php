<?php

namespace App\Repository;

use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use http\Params;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

/**
 * @extends ServiceEntityRepository<Station>
 *
 * @method Station|null find($id, $lockMode = null, $lockVersion = null)
 * @method Station|null findOneBy(array $criteria, array $orderBy = null)
 * @method Station[]    findAll()
 * @method Station[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Station::class);
    }

    public function add(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSelectedStations(int $type, string $city) {
        $params = [];
        $dql = 'SELECT s FROM App\Entity\Station s JOIN s.location l WHERE 1=1';
        if ($type != 1) {
            $dql.= ' AND s.type=:type';
            $params['type'] = $type;
        }
        if ($city != 'Select city') {
            $dql.= ' AND l.city=:city';
            $params['city'] = $city;
        }
        $query = $this->getEntityManager()->createQuery($dql)->setParameters($params);
        return $query->getResult();
    }

    public function getSelectedStationsType(int $type) {
        $dql = 'SELECT s FROM App\Entity\Station s JOIN s.location l WHERE s.type = :type';
        $query = $this->getEntityManager()->createQuery($dql)->setParameters(['type' => $type]);
        return $query->getResult();
    }

    public function getSelectedStationsCity(string $city) {
        $dql = 'SELECT s FROM App\Entity\Station s JOIN s.location l WHERE l.city = :city';
        $query = $this->getEntityManager()->createQuery($dql)->setParameters(['city' => $city]);
        return $query->getResult();
    }

//    /**
//     * @return Station[] Returns an array of Station objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Station
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
