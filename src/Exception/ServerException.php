<?php

namespace AlibabaCloud\Client\Exception;

use AlibabaCloud\Client\Result\Result;
use Stringy\Stringy;

/**
 * Class ServerException
 *
 * @package   AlibabaCloud\Client\Exception
 */
class ServerException extends AlibabaCloudException
{

    /**
     * @var string
     */
    protected $requestId;

    /**
     * @var Result
     */
    protected $result;

    /**
     * ServerException constructor.
     *
     * @param Result|null $result
     * @param string      $errorMessage
     * @param string      $errorCode
     */
    public function __construct(Result $result, $errorMessage = '', $errorCode = '')
    {
        $this->result = $result;
        $this->settingProperties();

        if ($errorCode !== '') {
            $this->errorCode = $errorCode;
        }

        if ($errorMessage !== '') {
            $this->errorMessage = $errorMessage;
        }

        if (!$this->errorMessage) {
            $this->errorMessage = (string)$this->result->getResponse()->getBody();
        }

        // If the string to be signed are the same with server's, it is considered a credential error.
        if ($this->result->getRequest()
            && Stringy::create($this->errorMessage)->contains($this->result->getRequest()->stringToBeSigned())) {
            $this->errorCode    = 'InvalidAccessKeySecret';
            $this->errorMessage = 'Specified Access Key Secret is not valid.';
        }

        parent::__construct(
            $this->getParentMessage(),
            $this->result->getResponse()->getStatusCode()
        );
    }

    /**
     * @return string
     */
    private function getParentMessage()
    {
        $data = $this->result->toArray();
        \ksort($data);
        $message = '';
        foreach ($data as $key => $value) {
            $message .= "$key:$value ";
        }
        return $message;
    }

    /**
     * @return void
     */
    private function settingProperties()
    {
        if (isset($this->result['message'])) {
            $this->errorMessage = $this->result['message'];
            $this->errorCode    = $this->result['code'];
        }
        if (isset($this->result['Message'])) {
            $this->errorMessage = $this->result['Message'];
            $this->errorCode    = $this->result['Code'];
        }
        if (isset($this->result['errorMsg'])) {
            $this->errorMessage = $this->result['errorMsg'];
            $this->errorCode    = $this->result['errorCode'];
        }
        if (isset($this->result['requestId'])) {
            $this->requestId = $this->result['requestId'];
        }
        if (isset($this->result['RequestId'])) {
            $this->requestId = $this->result['RequestId'];
        }
    }

    /**
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
     *
     * @return string
     */
    public function getErrorType()
    {
        return 'Server';
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated deprecated since version 2.0.
     *
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->getResult()->getResponse()->getStatusCode();
    }
}
