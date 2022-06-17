<?php

namespace Foodics\OAuth2\Client\Provider;

use Exception;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class FoodicsUser implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->getResponseValue('data.user.id');
    }

    /**
     * Get preferred name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getResponseValue('data.user.name');
    }

    /**
     * Get email address.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getResponseValue('data.user.email');
    }

    /**
     * Get mobile number.
     *
     * @return string|null
     */
    public function getMobile()
    {
        return $this->getResponseValue('data.user.phone');
    }

    /**
     * Get store id.
     *
     * @return string|null
     */
    public function getBusinessId()
    {
        return $this->getResponseValue('data.business.id');
    }

    /**
     * Get store id.
     *
     * @return string|null
     */
    public function getBusinessReference()
    {
        return $this->getResponseValue('data.business.reference');
    }

    /**
     * Get store name.
     *
     * @return string|null
     */
    public function getBusinessName() 
    {
        return $this->getResponseValue('data.business.name');
    }

    /**
     * Get store owner id.
     *
     * @return string|null
     */
    public function getBusinessOwnerID()
    {
        return $this->getResponseValue('data.business.owner_id');
    }

    /**
     * Get store owner email.
     *
     * @return string|null
     */
    public function getBusinessOwnerEmail()
    {
        return $this->getResponseValue('data.business.owner_email');
    }


    /**
     * Get store plan.
     *
     * @return string|null
     */
    public function getBusinessPlan()
    {
        return $this->getResponseValue('data.business.plan');
    }

    /**
     * Get store created at.
     *
     * @return \DateTime
     * @throws Exception
     */
    public function getBusinessCreatedAt()
    {
        return new \DateTime($this->getResponseValue('data.business.created_at'));
    }

    /**
     * Get user data as an array.
     *
     * @return array
     * @throws Exception
     */
    public function toArray()
    {
        try {
            return $this->response['data'];
        }catch (Exception $exception){
            throw new Exception('User data not found');
        }
    }


    private function getResponseValue($key)
    {
        $context = $this->response;
        $pieces = explode('.', $key);
        foreach ($pieces as $piece) {
            if (!is_array($context) || !array_key_exists($piece, $context)) {
                return null;
            }
            $context = &$context[$piece];
        }
        return $context;
    }
}
