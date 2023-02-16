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

namespace Evrinoma\MaterialBundle\PreValidator\Material;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
            ->checkMaterial($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkDescription($dto)
            ->checkActive($dto)
            ->checkPosition($dto)
            ->checkMaterial($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    private function checkDescription(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasDescription()) {
            throw new MaterialInvalidException('The Dto has\'t description');
        }

        return $this;
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new MaterialInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkTitle(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasTitle()) {
            throw new MaterialInvalidException('The Dto has\'t title');
        }

        return $this;
    }

    private function checkImage(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasImage()) {
            throw new MaterialInvalidException('The Dto has\'t Image file');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new MaterialInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkMaterial(DtoInterface $dto): self
    {
        /* @var MaterialApiDtoInterface $dto */

        return $this;
    }

    private function checkPreview(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasPreview()) {
            throw new MaterialInvalidException('The Dto has\'t Preview file');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var MaterialApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new MaterialInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
