<?php

namespace HGP\Vault\Services\Auth;


use HGP\Vault\Client;

/**
 * This service class handles Vault HTTP API endpoints starting in /auth/approle/
 */
class AppRole
{
    /**
     * Client instance
     *
     * @var Client
     */
    private $client;

    /**
     * Constructor - initialize Client field
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     *  Issues a Vault token based on the presented credentials.
     * @param string $roleId The role_id in Vault
     * @param string $secretId The secret_id in Vault
     * @return mixed
     */
    public function login($roleId, $secretId)
    {
        $body = ['role_id' => $roleId, 'secret_id' => $secretId];
        $params = [
            'body' => json_encode($body)
        ];
        return $this->client->post('/v1/auth/approle/login', $params);
    }

    /**
     * List the AppRoles defined in Vault
     * @return mixed
     */
    public function listRoles()
    {
        return $this->client->list('/v1/auth/approle/role');
    }

    /**
     * Get the ID for the specified AppRole
     * @param string $roleName
     * @return mixed
     */
    public function getRoleId(string $roleName)
    {
        return $this->client->get("/v1/auth/approle/role/$roleName/role-id");
    }


}