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

namespace Evrinoma\MaterialBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\AttachmentTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\MaterialBundle\DtoCommon\ValueObject\Mutable\MaterialApiDtoTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class FileApiDto extends AbstractDto implements FileApiDtoInterface
{
    use ActiveTrait;
    use AttachmentTrait;
    use DescriptionTrait;
    use IdTrait;
    use MaterialApiDtoTrait;
    use PositionTrait;

    /**
     * @Dto(class="Evrinoma\MaterialBundle\Dto\MaterialApiDto", generator="genRequestMaterialApiDto")
     */
    protected ?MaterialApiDtoInterface $materialApiDto = null;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(FileApiDtoInterface::ID);
            $active = $request->get(FileApiDtoInterface::ACTIVE);
            $description = $request->get(FileApiDtoInterface::DESCRIPTION);
            $position = $request->get(FileApiDtoInterface::POSITION);

            $files = ($request->files->has($this->getClass())) ? $request->files->get($this->getClass()) : [];

            try {
                if (\array_key_exists(FileApiDtoInterface::ATTACHMENT, $files)) {
                    $attachment = $files[FileApiDtoInterface::ATTACHMENT];
                } else {
                    $attachment = $request->get(FileApiDtoInterface::ATTACHMENT);
                    if (null !== $attachment) {
                        $attachment = new File($attachment);
                    }
                }
            } catch (\Exception $e) {
                $attachment = null;
            }

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($description) {
                $this->setDescription($description);
            }
            if ($attachment) {
                $this->setAttachment($attachment);
            }
            if ($position) {
                $this->setPosition($position);
            }
        }

        return $this;
    }
}
