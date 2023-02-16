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

namespace Evrinoma\MaterialBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;

trait MaterialApiDtoTrait
{
    public function setMaterialApiDto(MaterialApiDtoInterface $materialApiDto): DtoInterface
    {
        return parent::setMaterialApiDto($materialApiDto);
    }
}
