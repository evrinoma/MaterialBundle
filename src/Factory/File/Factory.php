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

namespace Evrinoma\MaterialBundle\Factory\File;

use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Entity\File\BaseFile;
use Evrinoma\MaterialBundle\Model\File\FileInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseFile::class;

    /**
     * @param FileApiDtoInterface $dto
     *
     * @return FileInterface
     */
    public function create(FileApiDtoInterface $dto): FileInterface
    {
        /* @var BaseFile $material */
        return new self::$entityClass();
    }
}
