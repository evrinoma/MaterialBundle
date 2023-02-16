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

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @throws MaterialInvalidException
     */
    public function onPost(MaterialApiDtoInterface $dto): void;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @throws MaterialInvalidException
     */
    public function onPut(MaterialApiDtoInterface $dto): void;

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @throws MaterialInvalidException
     */
    public function onDelete(MaterialApiDtoInterface $dto): void;
}
