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

namespace Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\MaterialBundle\Validator\TypeValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TypePass extends AbstractConstraint implements CompilerPassInterface
{
    public const TYPE_CONSTRAINT = 'evrinoma.material.constraint.property.type';

    protected static string $alias = self::TYPE_CONSTRAINT;
    protected static string $class = TypeValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
