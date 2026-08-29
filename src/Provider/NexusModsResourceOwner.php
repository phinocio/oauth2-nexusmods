<?php

namespace Phinocio\Oauth2NexusMods\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class NexusModsResourceOwner implements ResourceOwnerInterface
{
	public function __construct(public array $response) {}

	public function getUsername(): string
	{
		return $this->response['username'] ?? 'Meow';
	}

	public function getId(): int
	{
		return 1;
	}

	public function toArray(): array
	{
		return ['meow'];
	}
}
