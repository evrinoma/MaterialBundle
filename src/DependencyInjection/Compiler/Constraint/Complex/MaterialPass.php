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

namespace Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Complex;

use Evrinoma\MaterialBundle\Validator\MaterialValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class MaterialPass extends AbstractConstraint implements CompilerPassInterface
{
    public const MATERIAL_CONSTRAINT = 'evrinoma.material.constraint.complex.material';

    protected static string $alias = self::MATERIAL_CONSTRAINT;
    protected static string $class = MaterialValidator::class;
    protected static string $methodCall = 'addConstraint';
}
