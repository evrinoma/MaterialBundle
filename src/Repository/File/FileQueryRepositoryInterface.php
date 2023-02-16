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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\File\FileNotFoundException;
use Evrinoma\MaterialBundle\Exception\File\FileProxyException;
use Evrinoma\MaterialBundle\Model\File\FileInterface;

interface FileQueryRepositoryInterface
{
    /**
     * @param FileApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function findByCriteria(FileApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return FileInterface
     *
     * @throws FileNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): FileInterface;

    /**
     * @param string $id
     *
     * @return FileInterface
     *
     * @throws FileProxyException
     * @throws ORMException
     */
    public function proxy(string $id): FileInterface;
}
