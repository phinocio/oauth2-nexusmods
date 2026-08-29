<?php

namespace Phinocio\Oauth2NexusMods\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class NexusMods extends AbstractProvider
{
	protected const BASE_NEXUS_URL = 'https://users.nexusmods.com';

	public function getBaseAuthorizationUrl(): string
	{
		return self::BASE_NEXUS_URL . '/oauth/authorize';
	}

	public function getBaseAccessTokenUrl(array $params): string
	{
		return self::BASE_NEXUS_URL . '/oauth/token';
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token): string
	{
		return self::BASE_NEXUS_URL . '/oauth/userinfo';
	}

	protected function getDefaultScopes(): array
	{
		return [];
	}

	protected function checkResponse(ResponseInterface $response, $data): void
	{
		if (empty($data['error'])) {
			return;
		}

		$message = $data['error']['type'] . ': ' . $data['error']['message'];
		throw new IdentityProviderException($message, $data['error']['code'], $data);
	}

	protected function createResourceOwner(array $response, AccessToken $token): NexusModsResourceOwner
	{
		return new NexusModsResourceOwner($response);
	}
}
