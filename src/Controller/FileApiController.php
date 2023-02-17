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

namespace Evrinoma\MaterialBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\MaterialBundle\Dto\FileApiDtoInterface;
use Evrinoma\MaterialBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\MaterialBundle\Exception\File\FileInvalidException;
use Evrinoma\MaterialBundle\Exception\File\FileNotFoundException;
use Evrinoma\MaterialBundle\Facade\File\FacadeInterface;
use Evrinoma\MaterialBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class FileApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/material/file/create", options={"expose": true}, name="api_material_file_create")
     * @OA\Post(
     *     tags={"material"},
     *     description="the method perform create material type",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\MaterialBundle\Dto\FileApiDto"),
     *                         @OA\Property(property="description", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="attachment", type="string"),
     *                         @OA\Property(property="type[brief]", type="string"),
     *                         @OA\Property(property="material", type="object",
     *                             @OA\Property(property="class", type="string", default="Evrinoma\MaterialBundle\Dto\MaterialApiDto"),
     *                             @OA\Property(property="id", type="string", default="1"),
     *                         ),
     *                         @OA\Property(property="Evrinoma\MaterialBundle\Dto\FileApiDto[attachment]", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create material file")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var FileApiDtoInterface $fileApiDto */
        $fileApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_MATERIAL_FILE;

        try {
            $this->facade->post($fileApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create material file', $json, $error);
    }

    /**
     * @Rest\Post("/api/material/file/save", options={"expose": true}, name="api_material_file_save")
     * @OA\Post(
     *     tags={"material"},
     *     description="the method perform save material file for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\MaterialBundle\Dto\FileApiDto"),
     *                         @OA\Property(property="description", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="id", type="string"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="attachment", type="string"),
     *                         @OA\Property(property="type[brief]", type="string"),
     *                         @OA\Property(property="material", type="object",
     *                             @OA\Property(property="class", type="string", default="Evrinoma\MaterialBundle\Dto\MaterialApiDto"),
     *                             @OA\Property(property="id", type="string", default="1"),
     *                         ),
     *                         @OA\Property(property="Evrinoma\MaterialBundle\Dto\FileApiDto[attachment]", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save material file")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var FileApiDtoInterface $fileApiDto */
        $fileApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_MATERIAL_FILE;

        try {
            $this->facade->put($fileApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save material file', $json, $error);
    }

    /**
     * @Rest\Delete("/api/material/file/delete", options={"expose": true}, name="api_material_file_delete")
     * @OA\Delete(
     *     tags={"material"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MaterialBundle\Dto\FileApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete material file")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var FileApiDtoInterface $fileApiDto */
        $fileApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($fileApiDto, '', $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete material file', $json, $error);
    }

    /**
     * @Rest\Get("/api/material/file/criteria", options={"expose": true}, name="api_material_file_criteria")
     * @OA\Get(
     *     tags={"material"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MaterialBundle\Dto\FileApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="description",
     *         in="query",
     *         name="description",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type[brief]",
     *         in="query",
     *         description="Type Article",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 ref=@Model(type=Evrinoma\MaterialBundle\Form\Rest\Type\TypeChoiceType::class, options={"data": "brief"})
     *             ),
     *         ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=200, description="Return material file")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var FileApiDtoInterface $fileApiDto */
        $fileApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_MATERIAL_FILE;

        try {
            $this->facade->criteria($fileApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get material file', $json, $error);
    }

    /**
     * @Rest\Get("/api/material/file", options={"expose": true}, name="api_material_file")
     * @OA\Get(
     *     tags={"material"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MaterialBundle\Dto\FileApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return material file")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var FileApiDtoInterface $fileApiDto */
        $fileApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_MATERIAL_FILE;

        try {
            $this->facade->get($fileApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get material file', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof FileCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof FileNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof FileInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
