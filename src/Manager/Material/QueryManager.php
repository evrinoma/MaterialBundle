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

namespace Evrinoma\MaterialBundle\Manager\Material;

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialNotFoundException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialProxyException;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\MaterialBundle\Repository\Material\MaterialQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private MaterialQueryRepositoryInterface $repository;

    public function __construct(MaterialQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MaterialNotFoundException
     */
    public function criteria(MaterialApiDtoInterface $dto): array
    {
        try {
            $material = $this->repository->findByCriteria($dto);
        } catch (MaterialNotFoundException $e) {
            throw $e;
        }

        return $material;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialProxyException
     */
    public function proxy(MaterialApiDtoInterface $dto): MaterialInterface
    {
        try {
            if ($dto->hasId()) {
                $material = $this->repository->proxy($dto->idToString());
            } else {
                throw new MaterialProxyException('Id value is not set while trying get proxy object');
            }
        } catch (MaterialProxyException $e) {
            throw $e;
        }

        return $material;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialNotFoundException
     */
    public function get(MaterialApiDtoInterface $dto): MaterialInterface
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (MaterialNotFoundException $e) {
            throw $e;
        }

        return $material;
    }
}
