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

namespace Evrinoma\MaterialBundle\Repository\Material;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeSavedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialNotFoundException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialProxyException;
use Evrinoma\MaterialBundle\Mediator\Material\QueryMediatorInterface;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

trait MaterialRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param MaterialInterface $material
     *
     * @return bool
     *
     * @throws MaterialCannotBeSavedException
     * @throws ORMException
     */
    public function save(MaterialInterface $material): bool
    {
        try {
            $this->persistWrapped($material);
        } catch (ORMInvalidArgumentException $e) {
            throw new MaterialCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param MaterialInterface $material
     *
     * @return bool
     */
    public function remove(MaterialInterface $material): bool
    {
        return true;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MaterialNotFoundException
     */
    public function findByCriteria(MaterialApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $galleries = $this->mediator->getResult($dto, $builder);

        if (0 === \count($galleries)) {
            throw new MaterialNotFoundException('Cannot find material by findByCriteria');
        }

        return $galleries;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws MaterialNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): MaterialInterface
    {
        /** @var MaterialInterface $material */
        $material = $this->findWrapped($id);

        if (null === $material) {
            throw new MaterialNotFoundException("Cannot find material with id $id");
        }

        return $material;
    }

    /**
     * @param string $id
     *
     * @return MaterialInterface
     *
     * @throws MaterialProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MaterialInterface
    {
        $material = $this->referenceWrapped($id);

        if (!$this->containsWrapped($material)) {
            throw new MaterialProxyException("Proxy doesn't exist with $id");
        }

        return $material;
    }
}
