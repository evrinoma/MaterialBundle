<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\MaterialBundle\Repository\Orm\Material;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\MaterialBundle\Mediator\Material\QueryMediatorInterface;
use Evrinoma\MaterialBundle\Repository\Material\MaterialRepositoryInterface;
use Evrinoma\MaterialBundle\Repository\Material\MaterialRepositoryTrait;
use Evrinoma\UtilsBundle\Repository\Orm\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class MaterialRepository extends RepositoryWrapper implements MaterialRepositoryInterface, RepositoryWrapperInterface
{
    use MaterialRepositoryTrait;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
}
