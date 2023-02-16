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

use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeSavedException;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

interface MaterialCommandRepositoryInterface
{
    /**
     * @param MaterialInterface $material
     *
     * @return bool
     *
     * @throws MaterialCannotBeSavedException
     */
    public function save(MaterialInterface $material): bool;

    /**
     * @param MaterialInterface $material
     *
     * @return bool
     *
     * @throws MaterialCannotBeRemovedException
     */
    public function remove(MaterialInterface $material): bool;
}
