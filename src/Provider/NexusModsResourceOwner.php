<?php

declare(strict_types=1);

namespace Phinocio\Oauth2NexusMods\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;
use Phinocio\Oauth2NexusMods\Exception\InvalidUserInfoException;

class NexusModsResourceOwner implements ResourceOwnerInterface
{
	use ArrayAccessorTrait;

	/** @param array<string, mixed> $response */
	public function __construct(protected array $response) {}

	/** @return string */
	public function getId(): string
	{
		$value = $this->getValueByKey($this->response, 'sub');

		if (!is_string($value)) {
			throw new InvalidUserInfoException('sub', 'string', $value);
		}

		return $value;
	}

	/** @return string */
	public function getName(): string
	{
		$value = $this->getValueByKey($this->response, 'name');

		if (!is_string($value)) {
			throw new InvalidUserInfoException('name', 'string', $value);
		}

		return $value;
	}

	/** @return string */
	public function getAvatar(): ?string
	{
		$value = $this->getValueByKey($this->response, 'avatar');

		if ($value !== null && !is_string($value)) {
			throw new InvalidUserInfoException('avatar', 'string', $value);
		}

		return $value;
	}

	/**
	 * @return array<string>|null
	 */
	public function getMembershipRoles(): ?array
	{
		$value = $this->getValueByKey($this->response, 'membership_roles');

		if ($value === null) {
			return null;
		}

		if (!is_array($value)) {
			throw new InvalidUserInfoException('membership_roles', 'array', $value);
		}

		foreach ($value as $role) {
			if (!is_string($role)) {
				throw new InvalidUserInfoException('membership_roles', 'array<string>', $role);
			}
		}

		return $value;
	}


	/** @return int|null */
	public function getPremiumExpiry(): ?int
	{
		$value = $this->getValueByKey($this->response, 'premium_expiry');

		if ($value !== null && !is_int($value)) {
			throw new InvalidUserInfoException('premium_expiry', 'string', $value);
		}

		return $value;
	}

	/** @return bool */
	public function getAgeVerified(): bool
	{
		$value = $this->getValueByKey($this->response, 'age_verified');

		if (!is_bool($value)) {
			throw new InvalidUserInfoException('age_verified', 'bool', $value);
		}

		return $value;
	}

	/** @return array<string, mixed> */
	public function toArray(): array
	{
		return $this->response;
	}
}
