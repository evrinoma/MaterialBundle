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

namespace Evrinoma\MaterialBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Entity\File\BaseFile;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class FileFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            FileApiDtoInterface::DESCRIPTION => 'description ite',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 1,
            MaterialApiDtoInterface::MATERIAL => 0,
        ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description kzkt',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 2,
            MaterialApiDtoInterface::MATERIAL => 1,
        ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description c2m',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 3,
            MaterialApiDtoInterface::MATERIAL => 0,
        ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description kzkt2',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 4,
            MaterialApiDtoInterface::MATERIAL => 1,
            ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description nvr',
            FileApiDtoInterface::ACTIVE => 'b',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 5,
            MaterialApiDtoInterface::MATERIAL => 0,
        ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description nvr2',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 6,
            MaterialApiDtoInterface::MATERIAL => 1,
            ],
        [
            FileApiDtoInterface::DESCRIPTION => 'description nvr3',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::ATTACHMENT => 'PATH://TO_ATTACHMENT',
            FileApiDtoInterface::POSITION => 7,
            MaterialApiDtoInterface::MATERIAL => 2,
        ],
    ];

    protected static string $class = BaseFile::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = static::getReferenceName();
        $shortMaterial = MaterialFixtures::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setMaterial($this->getReference($shortMaterial.$record[MaterialApiDtoInterface::MATERIAL]))
                ->setActive($record[FileApiDtoInterface::ACTIVE])
                ->setPosition($record[FileApiDtoInterface::POSITION])
                ->setAttachment($record[FileApiDtoInterface::ATTACHMENT])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setDescription($record[FileApiDtoInterface::DESCRIPTION])
            ;

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::MATERIAL_FIXTURES, FixtureInterface::FILE_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 100;
    }
}
