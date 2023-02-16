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

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface as BaseMaterialApiDtoInterface;

interface MaterialApiDtoInterface
{
    public const MATERIAL = BaseMaterialApiDtoInterface::MATERIAL;

    public function hasMaterialApiDto(): bool;

    public function getMaterialApiDto(): BaseMaterialApiDtoInterface;
}
