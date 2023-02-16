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
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialInvalidException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialNotFoundException;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

interface CommandManagerInterface
{
    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialInvalidException
     */
    public function post(MaterialApiDtoInterface $dto): MaterialInterface;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialInvalidException
     * @throws MaterialNotFoundException
     */
    public function put(MaterialApiDtoInterface $dto): MaterialInterface;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @throws MaterialCannotBeRemovedException
     * @throws MaterialNotFoundException
     */
    public function delete(MaterialApiDtoInterface $dto): void;
}
