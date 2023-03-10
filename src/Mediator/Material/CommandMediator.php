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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\MaterialBundle\System\FileSystemInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;

    public function __construct(FileSystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function onUpdate(DtoInterface $dto, $entity): MaterialInterface
    {
        /* @var $dto MaterialApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $fileImage = $this->fileSystem->save($dto->getImage());
        $entity
            ->setDescription($dto->getDescription())
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setPreview($filePreview->getPathname())
            ->setImage($fileImage->getPathname())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        if ($dto->hasStart()) {
            $entity->setStart(new \DateTimeImmutable($dto->getStart()));
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): MaterialInterface
    {
        /* @var $dto MaterialApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $fileImage = $this->fileSystem->save($dto->getImage());
        $entity
            ->setDescription($dto->getDescription())
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setPreview($filePreview->getPathname())
            ->setImage($fileImage->getPathname())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        if ($dto->hasStart()) {
            $entity->setStart(new \DateTimeImmutable($dto->getStart()));
        }

        return $entity;
    }
}
