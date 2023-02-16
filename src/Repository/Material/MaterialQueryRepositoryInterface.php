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
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialNotFoundException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialProxyException;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

interface MaterialQueryRepositoryInterface
{
    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MaterialNotFoundException
     */
    public function findByCriteria(MaterialApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return MaterialInterface
     *
     * @throws MaterialNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): MaterialInterface;

    /**
     * @param string $id
     *
     * @return MaterialInterface
     *
     * @throws MaterialProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MaterialInterface;
}
