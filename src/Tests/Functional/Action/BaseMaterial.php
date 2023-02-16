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

namespace Evrinoma\MaterialBundle\Tests\Functional\Action;

use Evrinoma\MaterialBundle\Dto\MaterialApiDto;
use Evrinoma\MaterialBundle\Dto\MaterialApiDtoInterface;
use Evrinoma\MaterialBundle\Tests\Functional\Helper\BaseMaterialTestTrait;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Active;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Description;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Id;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Image;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Position;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Preview;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Start;
use Evrinoma\MaterialBundle\Tests\Functional\ValueObject\Material\Title;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseMaterial extends AbstractServiceTest implements BaseMaterialTestInterface
{
    use BaseMaterialTestTrait;

    public const API_GET = 'evrinoma/api/material';
    public const API_CRITERIA = 'evrinoma/api/material/criteria';
    public const API_DELETE = 'evrinoma/api/material/delete';
    public const API_PUT = 'evrinoma/api/material/save';
    public const API_POST = 'evrinoma/api/material/create';

    protected string $methodPut = ApiBrowserTestInterface::POST;

    protected static array $header = ['CONTENT_TYPE' => 'multipart/form-data'];
    protected bool $form = true;

    protected static function getDtoClass(): string
    {
        return MaterialApiDto::class;
    }

    protected static function defaultData(): array
    {
        static::initFiles();

        return [
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ID => Id::value(),
            MaterialApiDtoInterface::TITLE => Title::default(),
            MaterialApiDtoInterface::POSITION => Position::value(),
            MaterialApiDtoInterface::ACTIVE => Active::value(),
            MaterialApiDtoInterface::DESCRIPTION => Description::default(),
            MaterialApiDtoInterface::START => Start::default(),
            MaterialApiDtoInterface::IMAGE => Image::default(),
            MaterialApiDtoInterface::PREVIEW => Preview::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createMaterial();
        $this->testResponseStatusCreated();

        static::$files = [];

        $this->createMaterial();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ACTIVE => Active::wrong(),
        ]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ID => Id::value(),
            MaterialApiDtoInterface::ACTIVE => Active::block(),
            MaterialApiDtoInterface::TITLE => Title::wrong(),
        ]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ACTIVE => Active::value(),
            MaterialApiDtoInterface::ID => Id::value(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ACTIVE => Active::delete(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([
            MaterialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MaterialApiDtoInterface::ACTIVE => Active::delete(),
            MaterialApiDtoInterface::TITLE => Title::value(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $query = static::getDefault([
            MaterialApiDtoInterface::ID => Id::value(),
            MaterialApiDtoInterface::TITLE => Title::value(),
            MaterialApiDtoInterface::POSITION => Position::value(),
            MaterialApiDtoInterface::DESCRIPTION => Description::value(),
        ]);

        $find = $this->assertGet(Id::value());

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);

        static::$files = [];

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::blank());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            MaterialApiDtoInterface::ID => Id::wrong(),
            MaterialApiDtoInterface::TITLE => Title::wrong(),
            MaterialApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createMaterial();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::TITLE => Title::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::POSITION => Position::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::DESCRIPTION => Description::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[static::getDtoClass()][MaterialApiDtoInterface::IMAGE]);
        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::IMAGE => Image::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[static::getDtoClass()][MaterialApiDtoInterface::PREVIEW]);
        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::PREVIEW => Preview::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::PREVIEW => Preview::blank(),
            MaterialApiDtoInterface::IMAGE => Image::blank(),
        ]);
        static::$files[static::getDtoClass()] = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            MaterialApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MaterialApiDtoInterface::ID],
            MaterialApiDtoInterface::IMAGE => Image::blank(),
            MaterialApiDtoInterface::PREVIEW => Preview::blank(),
        ]);
        static::$files = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createMaterial();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankTitle();
        $this->testResponseStatusUnprocessable();
    }
}
