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

namespace Evrinoma\MaterialBundle\Tests\Functional\Helper;

use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait BaseMaterialTestTrait
{
    protected static function initFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'http');

        file_put_contents($path, 'my_file');

        $fileImage = $filePreview = new UploadedFile($path, 'my_file');

        static::$files = [
            static::getDtoClass() => [
                MaterialApiDtoInterface::IMAGE => $fileImage,
                MaterialApiDtoInterface::PREVIEW => $filePreview,
                ],
        ];
    }

    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createMaterial(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function compareResults(array $value, array $entity, array $query): void
    {
        Assert::assertEquals($value[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID], $entity[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID]);
        Assert::assertEquals($query[MaterialApiDtoInterface::TITLE], $entity[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::TITLE]);
        Assert::assertEquals($query[MaterialApiDtoInterface::DESCRIPTION], $entity[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::DESCRIPTION]);
        Assert::assertEquals($query[MaterialApiDtoInterface::POSITION], $entity[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::POSITION]);
    }

    protected function createConstraintBlankTitle(): array
    {
        $query = static::getDefault([MaterialApiDtoInterface::TITLE => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkMaterial($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkMaterial($entity): void
    {
        Assert::assertArrayHasKey(MaterialApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::TITLE, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::PREVIEW, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::POSITION, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::DESCRIPTION, $entity);
        Assert::assertArrayHasKey(MaterialApiDtoInterface::START, $entity);
    }
}
