<?php

namespace AlibabaCloud\Client\Request\Traits;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * @package    AlibabaCloud\Client\Request\Traits
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  2019 Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 */
trait DeprecatedRoaTrait
{

    /**
     * @deprecated
     *
     * @param string $uriPattern
     *
     * @return $this
     */
    public function setUriPattern($uriPattern)
    {
        return $this->pathPattern($uriPattern);
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getUriPattern()
    {
        return $this->pathPattern;
    }

    /**
     * @deprecated
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function putPathParameter($name, $value)
    {
        return $this->pathParameter($name, $value);
    }

    /**
     * @deprecated
     *
     * @return array
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }
}