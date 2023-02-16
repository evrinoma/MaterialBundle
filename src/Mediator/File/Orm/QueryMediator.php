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

namespace Evrinoma\MaterialBundle\Mediator\File\Orm;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Mediator\File\QueryMediatorInterface;
use Evrinoma\MaterialBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\UtilsBundle\Mediator\Orm\QueryMediatorTrait;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    use QueryMediatorTrait;

    protected static string $alias = AliasInterface::FILE;

    /**
     * @param DtoInterface          $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        /** @var $dto FileApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }

        if ($dto->hasDescription()) {
            $builder
                ->andWhere($alias.'.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }

        $aliasMaterial = AliasInterface::MATERIAL;
        $builder
            ->leftJoin($alias.'.material', $aliasMaterial)
            ->addSelect($aliasMaterial);

        if ($dto->hasMaterialApiDto()) {
            if ($dto->getMaterialApiDto()->hasId()) {
                $builder->andWhere($aliasMaterial.'.id = :idMaterial')
                    ->setParameter('idMaterial', $dto->getMaterialApiDto()->getId());
            }
        }
    }
}
