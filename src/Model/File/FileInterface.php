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

use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\AttachmentInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface FileInterface extends ActiveInterface, IdInterface, DescriptionInterface, CreateUpdateAtInterface, AttachmentInterface
{
    public function resetMaterial(): FileInterface;

    public function hasMaterial(): bool;

    public function getMaterial(): MaterialInterface;

    public function setMaterial(MaterialInterface $material): FileInterface;
}
