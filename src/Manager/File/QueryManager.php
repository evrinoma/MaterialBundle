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

namespace Evrinoma\MaterialBundle\Manager\File;

use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\File\FileNotFoundException;
use Evrinoma\MaterialBundle\Exception\File\FileProxyException;
use Evrinoma\MaterialBundle\Model\File\FileInterface;
use Evrinoma\MaterialBundle\Repository\File\FileQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private FileQueryRepositoryInterface $repository;

    public function __construct(FileQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FileApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function criteria(FileApiDtoInterface $dto): array
    {
        try {
            $material = $this->repository->findByCriteria($dto);
        } catch (FileNotFoundException $e) {
            throw $e;
        }

        return $material;
    }

    /**
     * @param FileApiDtoInterface $dto
     *
     * @return FileInterface
     *
     * @throws FileProxyException
     */
    public function proxy(FileApiDtoInterface $dto): FileInterface
    {
        try {
            if ($dto->hasId()) {
                $material = $this->repository->proxy($dto->idToString());
            } else {
                throw new FileProxyException('Id value is not set while trying get proxy object');
            }
        } catch (FileProxyException $e) {
            throw $e;
        }

        return $material;
    }

    /**
     * @param FileApiDtoInterface $dto
     *
     * @return FileInterface
     *
     * @throws FileNotFoundException
     */
    public function get(FileApiDtoInterface $dto): FileInterface
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (FileNotFoundException $e) {
            throw $e;
        }

        return $material;
    }
}
