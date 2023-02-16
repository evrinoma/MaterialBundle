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

namespace Evrinoma\MaterialBundle\Mediator\Material;

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeCreatedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeSavedException;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

interface CommandMediatorInterface
{
    /**
     * @param MaterialApiDtoInterface $dto
     * @param MaterialInterface       $entity
     *
     * @return MaterialInterface
     *
     * @throws MaterialCannotBeSavedException
     */
    public function onUpdate(MaterialApiDtoInterface $dto, MaterialInterface $entity): MaterialInterface;

    /**
     * @param MaterialApiDtoInterface $dto
     * @param MaterialInterface       $entity
     *
     * @throws MaterialCannotBeRemovedException
     */
    public function onDelete(MaterialApiDtoInterface $dto, MaterialInterface $entity): void;

    /**
     * @param MaterialApiDtoInterface $dto
     * @param MaterialInterface       $entity
     *
     * @return MaterialInterface
     *
     * @throws MaterialCannotBeSavedException
     * @throws MaterialCannotBeCreatedException
     */
    public function onCreate(MaterialApiDtoInterface $dto, MaterialInterface $entity): MaterialInterface;
}
