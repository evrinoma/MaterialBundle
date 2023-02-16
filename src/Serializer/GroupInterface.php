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

namespace Evrinoma\MaterialBundle\Serializer;

interface GroupInterface
{
    public const API_POST_MATERIAL = 'API_POST_MATERIAL';
    public const API_PUT_MATERIAL = 'API_PUT_MATERIAL';
    public const API_GET_MATERIAL = 'API_GET_MATERIAL';
    public const API_CRITERIA_MATERIAL = self::API_GET_MATERIAL;
    public const APP_GET_BASIC_MATERIAL = 'APP_GET_BASIC_MATERIAL';

    public const API_POST_MATERIAL_TYPE = 'API_POST_MATERIAL_TYPE';
    public const API_PUT_MATERIAL_TYPE = 'API_PUT_MATERIAL_TYPE';
    public const API_GET_MATERIAL_TYPE = 'API_GET_MATERIAL_TYPE';
    public const API_CRITERIA_MATERIAL_TYPE = self::API_GET_MATERIAL_TYPE;
    public const APP_GET_BASIC_MATERIAL_TYPE = 'APP_GET_BASIC_MATERIAL_TYPE';

    public const API_POST_MATERIAL_FILE = 'API_POST_MATERIAL_FILE';
    public const API_PUT_MATERIAL_FILE = 'API_PUT_MATERIAL_FILE';
    public const API_GET_MATERIAL_FILE = 'API_GET_MATERIAL_FILE';
    public const API_CRITERIA_MATERIAL_FILE = self::API_GET_MATERIAL_FILE;
    public const APP_GET_BASIC_MATERIAL_FILE = 'APP_GET_BASIC_MATERIAL_FILE';
}
