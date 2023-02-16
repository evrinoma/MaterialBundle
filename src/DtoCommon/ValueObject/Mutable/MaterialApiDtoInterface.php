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

namespace Evrinoma\MaterialBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface as BaseMaterialApiDtoInterface;

interface MaterialApiDtoInterface
{
    public function setMaterialApiDto(BaseMaterialApiDtoInterface $materialApiDto): DtoInterface;
}
