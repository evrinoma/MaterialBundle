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
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Entity\Material\BaseMaterial;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class MaterialFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        0=>[
            MaterialApiDtoInterface::TITLE => 'ite',
            MaterialApiDtoInterface::POSITION => 1,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'a',
            MaterialApiDtoInterface::START => '2008-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        1=>[
            MaterialApiDtoInterface::TITLE => 'kzkt',
            MaterialApiDtoInterface::POSITION => 2,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'a',
            MaterialApiDtoInterface::START => '2015-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        2=>[
            MaterialApiDtoInterface::TITLE => 'c2m',
            MaterialApiDtoInterface::POSITION => 3,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'a',
            MaterialApiDtoInterface::START => '2020-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        3=>[
            MaterialApiDtoInterface::TITLE => 'kzkt2',
            MaterialApiDtoInterface::POSITION => 1,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'd',
            MaterialApiDtoInterface::START => '2015-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        4=>[
            MaterialApiDtoInterface::TITLE => 'nvr',
            MaterialApiDtoInterface::POSITION => 2,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'b',
            MaterialApiDtoInterface::START => '2010-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        5=>[
            MaterialApiDtoInterface::TITLE => 'nvr2',
            MaterialApiDtoInterface::POSITION => 3,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'd',
            MaterialApiDtoInterface::START => '2010-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        6=>[
            MaterialApiDtoInterface::TITLE => 'nvr3',
            MaterialApiDtoInterface::POSITION => 1,
            MaterialApiDtoInterface::DESCRIPTION => 'desc',
            MaterialApiDtoInterface::ACTIVE => 'd',
            MaterialApiDtoInterface::START => '2011-10-23 10:21:50',
            MaterialApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            MaterialApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
    ];

    protected static string $class = BaseMaterial::class;

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
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setPreview($record[MaterialApiDtoInterface::PREVIEW])
                ->setActive($record[MaterialApiDtoInterface::ACTIVE])
                ->setTitle($record[MaterialApiDtoInterface::TITLE])
                ->setPosition($record[MaterialApiDtoInterface::POSITION])
                ->setDescription($record[MaterialApiDtoInterface::DESCRIPTION])
                ->setStart(new \DateTimeImmutable($record[MaterialApiDtoInterface::START]))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setImage($record[MaterialApiDtoInterface::IMAGE])
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
            FixtureInterface::MATERIAL_FIXTURES
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
