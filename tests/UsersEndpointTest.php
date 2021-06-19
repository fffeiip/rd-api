<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersEndpointTest extends TestCase
{
    use DatabaseTransactions;

    public function userprovider() : Array
    {
        return [[[
            "name" => "PhpUniter",
            'email' => "oi322@email.com"
        ]]];
    }

    /**
     * @dataProvider userprovider
     */
    public function testUserPost($user)
    {
        $user["password"] = "phpunit123";
        $user["password_confirm"] ="phpunit123";
        $this->json('POST','api/users', $user)->seeJson([
            "name" => $user["name"],
            "email" => $user["email"],
        ]);
    }


    /**
     * @dataProvider userProvider
     */
    public function testUserInvalidPassword($user)
    {

        $user["password"] = "php";
        $user["password_confirm"] ="php";
        $json_response = $this->json('POST','api/users', $user);
        $json_response->seeJson([
            "error" => [
                "code" => 422,
                "message" => "The given data was invalid.",
            ]
        ]);
        $this->assertEquals(422, $json_response->response->getStatusCode());
    }

    /**
     * @dataProvider userProvider
     */
    public function testUserInvalidPasswordConfirmation($user)
    {

        $user["password"] = "phpunit456";
        $user["password_confirm"] ="phpunit123";

        $json_response = $this->json('POST','api/users', $user);

        $json_response->seeJson([
            "error" => [
                "code" => 422,
                "message" => "The given data was invalid.",
            ]
        ]);
        $this->assertEquals(422, $json_response->response->getStatusCode());
    }

    public function testAuthRoute()
    {
        $user = $this->json('POST','api/users', [
            "name" => "PhpUniter",
            'email' => "oi322@email.com",
            'password' => "phpunit123",
            'password_confirm' => "phpunit123"
        ])->response->getData();

        $response_login = $this->json('POST','/login', [
            "email" => $user->email,
            "password" => "phpunit123"
        ]);

        $api_token = $response_login->response->getData()->api_token;
        $endpoint = 'api/users/'.$user->id;
        $header = ["api_token" => $api_token];
        $response_get_user = $this->get($endpoint, $header);

        $this->assertEquals(200, $response_get_user->response->status());

    }


}
