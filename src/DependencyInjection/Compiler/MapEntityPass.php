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

namespace Evrinoma\MaterialBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping;
use Evrinoma\MaterialBundle\DependencyInjection\EvrinomaMaterialExtension;
use Evrinoma\MaterialBundle\Entity\File\BaseFile;
use Evrinoma\MaterialBundle\Model\File\FileInterface;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.material.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaMaterialExtension::ENTITY]);

            $entityFile = BaseFile::class;

            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/File', '%s/Entity/File');

            $this->addResolveTargetEntity([$entityFile => [FileInterface::class => []]], false);

            $entityMaterial = $container->getParameter('evrinoma.material.entity');
            if (str_contains($entityMaterial, EvrinomaMaterialExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Material', '%s/Entity/Material');
            }
            $this->addResolveTargetEntity([$entityMaterial => [MaterialInterface::class => []]], false);

            $mapping = $this->getMapping($entityFile);
            $this->addResolveTargetEntity([$entityFile => [FileInterface::class => ['inherited' => true, 'joinTable' => $mapping]]], false);
        }
    }

    private function getMapping(string $className): array
    {
        $annotationReader = new AnnotationReader();
        $reflectionClass = new \ReflectionClass($className);
        $joinTableAttribute = $annotationReader->getClassAnnotation($reflectionClass, Mapping\Table::class);

        return ($joinTableAttribute) ? ['name' => $joinTableAttribute->name] : [];
    }
}
