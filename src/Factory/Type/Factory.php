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

namespace Evrinoma\MaterialBundle\Factory\Type;

use Evrinoma\MaterialBundle\Dto\TypeApiDtoInterface;
use Evrinoma\MaterialBundle\Entity\Type\BaseType;
use Evrinoma\MaterialBundle\Model\Type\TypeInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseType::class;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     */
    public function create(TypeApiDtoInterface $dto): TypeInterface
    {
        /* @var BaseType $material */
        return new self::$entityClass();
    }
}
