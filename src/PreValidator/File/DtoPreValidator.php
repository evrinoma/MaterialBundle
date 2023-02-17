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

namespace Evrinoma\MaterialBundle\PreValidator\File;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\File\FileInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkMaterial($dto)
            ->checkAttachment($dto)
            ->checkType($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
        ;
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkMaterial($dto)
            ->checkAttachment($dto)
            ->checkId($dto)
            ->checkType($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
            ->checkActive($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    private function checkType(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasTypeApiDto()) {
            throw new FileInvalidException('The Dto has\'t type');
        }

        return $this;
    }

    private function checkMaterial(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasMaterialApiDto()) {
            throw new FileInvalidException('The Dto has\'t material');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new FileInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkDescription(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasDescription()) {
            throw new FileInvalidException('The Dto has\'t description');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new FileInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new FileInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkAttachment(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasAttachment()) {
            throw new FileInvalidException('The Dto has\'t Attachment file');
        }

        return $this;
    }
}
