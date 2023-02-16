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

namespace Evrinoma\MaterialBundle\Mediator\File;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\File\FileCannotBeCreatedException;
use Evrinoma\MaterialBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\MaterialBundle\Manager\Material\QueryManagerInterface as MaterialQueryManagerInterface;
use Evrinoma\MaterialBundle\Model\File\FileInterface;
use Evrinoma\MaterialBundle\System\FileSystemInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;
    private MaterialQueryManagerInterface $materialQueryManager;

    public function __construct(FileSystemInterface $fileSystem, MaterialQueryManagerInterface $materialQueryManager)
    {
        $this->fileSystem = $fileSystem;
        $this->materialQueryManager = $materialQueryManager;
    }

    public function onUpdate(DtoInterface $dto, $entity): FileInterface
    {
        /* @var $dto FileApiDtoInterface */
        $fileAttachment = $this->fileSystem->save($dto->getAttachment());

        try {
            $entity->setMaterial($this->materialQueryManager->proxy($dto->getMaterialApiDto()));
        } catch (\Exception $e) {
            throw new FileCannotBeSavedException($e->getMessage());
        }

        $entity
            ->setDescription($dto->getDescription())
            ->setPosition($dto->getPosition())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setAttachment($fileAttachment->getPathname())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): FileInterface
    {
        /* @var $dto FileApiDtoInterface */
        $fileAttachment = $this->fileSystem->save($dto->getAttachment());

        try {
            $entity->setMaterial($this->materialQueryManager->proxy($dto->getMaterialApiDto()));
        } catch (\Exception $e) {
            throw new FileCannotBeCreatedException($e->getMessage());
        }

        $entity
            ->setDescription($dto->getDescription())
            ->setPosition($dto->getPosition())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setAttachment($fileAttachment->getPathname())
            ->setActiveToActive();

        return $entity;
    }
}
