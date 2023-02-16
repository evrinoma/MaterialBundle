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

namespace Evrinoma\MaterialBundle\Model\File;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\AttachmentTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\DescriptionTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\PositionTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractFile implements FileInterface
{
    use ActiveTrait;
    use CreateUpdateAtTrait;
    use DescriptionTrait;
    use IdTrait;
    use PositionTrait;
    use AttachmentTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\MaterialBundle\Model\Material\MaterialInterface")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected ?MaterialInterface $material = null;

    /**
     * @return MaterialInterface
     */
    public function getMaterial(): MaterialInterface
    {
        return $this->material;
    }

    public function resetMaterial(): FileInterface
    {
        $this->material = null;

        return $this;
    }

    /**
     * @param MaterialInterface $material
     *
     * @return FileInterface
     */
    public function setMaterial(MaterialInterface $material): FileInterface
    {
        $this->material = $material;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMaterial(): bool
    {
        return null !== $this->material;
    }
}