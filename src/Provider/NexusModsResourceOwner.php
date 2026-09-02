<?php

namespace Phinocio\Oauth2NexusMods\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class NexusModsResourceOwner implements ResourceOwnerInterface
{
	use ArrayAccessorTrait;

	public function __construct(protected array $response) {}

	public function getId()
	{
		return $this->getValueByKey($this->response, 'sub');
	}

	public function getName(): ?string
	{
		return $this->getValueByKey($this->response, 'name');
	}

	public function getAvatar(): ?string
	{
		return $this->getValueByKey($this->response, 'avatar');
	}

	public function getMembershipRoles(): ?array
	{
		return $this->getValueByKey($this->response, 'membership_roles');
	}

	public function getPremiumExpiry(): ?string
	{
		return $this->getValueByKey($this->response, 'premium_expiry');
	}

	public function getAgeVerified(): ?bool
	{
		return $this->getValueByKey($this->response, 'age_verified');
	}

	public function toArray(): array
	{
		return $this->response;
	}
}
