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

namespace Evrinoma\MaterialBundle;

use Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Complex\MaterialPass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Property\FilePass as PropertyFilePass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Property\MaterialPass as PropertyMaterialPass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\Constraint\Property\TypePass as PropertyTypePass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\MaterialBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\MaterialBundle\DependencyInjection\EvrinomaMaterialExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaMaterialBundle extends Bundle
{
    public const BUNDLE = 'material';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new PropertyMaterialPass())
            ->addCompilerPass(new PropertyFilePass())
            ->addCompilerPass(new PropertyTypePass())
            ->addCompilerPass(new MaterialPass())
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaMaterialExtension();
        }

        return $this->extension;
    }
}
