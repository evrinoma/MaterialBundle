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

namespace Evrinoma\MaterialBundle\Manager\Type;

use Evrinoma\MaterialBundle\Dto\TypeApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\Type\TypeCannotBeCreatedException;
use Evrinoma\MaterialBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\MaterialBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\MaterialBundle\Exception\Type\TypeInvalidException;
use Evrinoma\MaterialBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\MaterialBundle\Factory\Type\FactoryInterface;
use Evrinoma\MaterialBundle\Mediator\Type\CommandMediatorInterface;
use Evrinoma\MaterialBundle\Model\Type\TypeInterface;
use Evrinoma\MaterialBundle\Repository\Type\TypeRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private TypeRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param TypeRepositoryInterface  $repository
     * @param FactoryInterface         $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, TypeRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     * @throws TypeCannotBeCreatedException
     * @throws TypeCannotBeSavedException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface
    {
        $material = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $material);

        $errors = $this->validator->validate($material);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($material);

        return $material;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     * @throws TypeCannotBeSavedException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $material);

        $errors = $this->validator->validate($material);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($material);

        return $material;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void
    {
        try {
            $material = $this->repository->find($dto->idToString());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $material);
        try {
            $this->repository->remove($material);
        } catch (TypeCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
