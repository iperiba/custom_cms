<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Object_;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getArticleBySlugAndCategory(string $slug, string $category): ?Article
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT a.id
            FROM article a
            INNER JOIN article_category ac
            ON a.id = ac.article_id
            INNER JOIN category c
            ON c.id = ac.category_id 
            WHERE c.slug  = :category
            AND a.slug = :slug';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['category' => $category, 'slug' => $slug]);
        $id = $resultSet->fetchOne();
        $Article = $this->findOneBy(['id' => $id]);

        return $Article;
    }
}
