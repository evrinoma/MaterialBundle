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

namespace Evrinoma\MaterialBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface TypeApiDtoInterface extends DtoInterface, IdInterface, BriefInterface, DescriptionInterface, ActiveInterface
{
    public const TYPE = 'type';
}
