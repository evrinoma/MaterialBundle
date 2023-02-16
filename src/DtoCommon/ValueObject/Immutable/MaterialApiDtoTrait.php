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

namespace Evrinoma\MaterialBundle\DtoCommon\ValueObject\Immutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDto;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait MaterialApiDtoTrait
{
    protected ?MaterialApiDtoInterface $materialApiDto = null;

    protected static string $classMaterialApiDto = MaterialApiDto::class;

    public function genRequestMaterialApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $material = $request->get(MaterialApiDtoInterface::MATERIAL);
            if ($material) {
                $newRequest = $this->getCloneRequest();
                $material[DtoInterface::DTO_CLASS] = static::$classMaterialApiDto;
                $newRequest->request->add($material);

                yield $newRequest;
            }
        }
    }

    public function hasMaterialApiDto(): bool
    {
        return null !== $this->materialApiDto;
    }

    public function getMaterialApiDto(): MaterialApiDtoInterface
    {
        return $this->materialApiDto;
    }
}
