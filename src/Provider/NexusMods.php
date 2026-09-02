<?php

declare(strict_types=1);

namespace Phinocio\Oauth2NexusMods\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class NexusMods extends AbstractProvider
{
    use BearerAuthorizationTrait;

    protected const BASE_NEXUS_URL = 'https://users.nexusmods.com';

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return self::BASE_NEXUS_URL . '/oauth/authorize';
    }

    /**
     * @param array<string, string> $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return self::BASE_NEXUS_URL . '/oauth/token';
    }

    /**
     * @param AccessToken $token
     * @return string
     * */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return self::BASE_NEXUS_URL . '/oauth/userinfo';
    }

    /** @return array<int, string> */
    protected function getDefaultScopes(): array
    {
        return ['openid public profile'];
    }

    /**
     * @param ResponseInterface $response
     * @param string|array<string, array<string,string|int>> $data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (empty($data['error'])) {
            return;
        }

        $message = $data['error']['type'] . ': ' . $data['error']['message'];
        throw new IdentityProviderException($message, (int) $data['error']['code'], $data);
    }

    /**
     * @param array<string> $response
     * @param AccessToken $token
     * @return NexusModsResourceOwner
     * */
    protected function createResourceOwner(array $response, AccessToken $token): NexusModsResourceOwner
    {
        return new NexusModsResourceOwner($response);
    }
}
