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

namespace Evrinoma\MaterialBundle\Repository\File;

use Evrinoma\MaterialBundle\Exception\File\FileCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\MaterialBundle\Model\File\FileInterface;

interface FileCommandRepositoryInterface
{
    /**
     * @param FileInterface $file
     *
     * @return bool
     *
     * @throws FileCannotBeSavedException
     */
    public function save(FileInterface $file): bool;

    /**
     * @param FileInterface $file
     *
     * @return bool
     *
     * @throws FileCannotBeRemovedException
     */
    public function remove(FileInterface $type): bool;
}
