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

namespace Evrinoma\MaterialBundle\Manager\Material;

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeCreatedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialCannotBeSavedException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialInvalidException;
use Evrinoma\MaterialBundle\Exception\Material\MaterialNotFoundException;
use Evrinoma\MaterialBundle\Factory\Material\FactoryInterface;
use Evrinoma\MaterialBundle\Mediator\Material\CommandMediatorInterface;
use Evrinoma\MaterialBundle\Model\Material\MaterialInterface;
use Evrinoma\MaterialBundle\Repository\Material\MaterialRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private MaterialRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    public function __construct(ValidatorInterface $validator, MaterialRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialInvalidException
     * @throws MaterialCannotBeCreatedException
     * @throws MaterialCannotBeSavedException
     */
    public function post(MaterialApiDtoInterface $dto): MaterialInterface
    {
        $material = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $material);

        $errors = $this->validator->validate($material);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MaterialInvalidException($errorsString);
        }

        $this->repository->save($material);

        return $material;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @return MaterialInterface
     *
     * @throws MaterialInvalidException
     * @throws MaterialNotFoundException
     * @throws MaterialCannotBeSavedException
     */
    public function put(MaterialApiDtoInterface $dto): MaterialInterface
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (MaterialNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $material);

        $errors = $this->validator->validate($material);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MaterialInvalidException($errorsString);
        }

        $this->repository->save($material);

        return $material;
    }

    /**
     * @param MaterialApiDtoInterface $dto
     *
     * @throws MaterialCannotBeRemovedException
     * @throws MaterialNotFoundException
     */
    public function delete(MaterialApiDtoInterface $dto): void
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (MaterialNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $material);
        try {
            $this->repository->remove($material);
        } catch (MaterialCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
