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

interface QueryManagerInterface
{
    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MaterialNotFoundException
     */
    public function criteria(MaterialApiDtoInterface $dto): array;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialNotFoundException
     */
    public function get(MaterialApiDtoInterface $dto): MaterialInterface;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialProxyException
     */
    public function proxy(MaterialApiDtoInterface $dto): MaterialInterface;
}
