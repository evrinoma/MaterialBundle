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

namespace Evrinoma\MaterialBundle\Repository\Type;

use Evrinoma\MaterialBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\MaterialBundle\Model\Type\TypeInterface;

interface TypeCommandRepositoryInterface
{
    /**
     * @param TypeInterface $type
     *
     * @return bool
     *
     * @throws TypeCannotBeSavedException
     */
    public function save(TypeInterface $type): bool;

    /**
     * @param TypeInterface $type
     *
     * @return bool
     *
     * @throws TypeCannotBeRemovedException
     */
    public function remove(TypeInterface $type): bool;
}
