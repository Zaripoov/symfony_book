<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method BookCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookCategory[]    findAll()
 * @method BookCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCategory::class);
    }

    /**
     * @return BookCategory[]
     */
    public function findAllSortedByTitle(): array
    {
        return $this->findBy([], ['title' => Criteria::ASC]);
    }
}
