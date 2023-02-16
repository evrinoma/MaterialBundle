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

namespace Evrinoma\MaterialBundle\Factory\Material;

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Entity\Material\BaseMaterial;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseMaterial::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     */
    public function create(MaterialApiDtoInterface $dto): MaterialInterface
    {
        /* @var BaseMaterial $material */
        return new self::$entityClass();
    }
}
