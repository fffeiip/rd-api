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
        $user = [
            "name" => "PhpUniter",
            'email' => "oi322@email.com",
            'password' => "phpunit123",
            'password_confirm' => "phpunit123"
        ];

        $new_user = $this->json('POST','api/users', $user)->response->getData();

        $api_token = $this->getApiToken([
            'email' => "oi322@email.com",
            'password' => "phpunit123"
        ]);

        $endpoint = 'api/users/'.$new_user->id;
        $header = ["api_token" => $api_token];
        $response_get_user = $this->get($endpoint, $header);

        $this->assertEquals(200, $response_get_user->response->status());

    }

    /**
     * @dataProvider userprovider
     */
    public function testUpdateUser($user)
    {
        $user["password"] = "php12345";
        $user["password_confirm"] ="php12345";

        $new_user = $this->json('POST','api/users', $user)->response->getData();

        $api_token = $this->getApiToken($user);
        $url = 'api/users/' . $new_user->id;
        $header = ["api_token" => $api_token];
        $response = $this->put($url, [
            "name" => "Jorgin"
        ] ,$header);

        $this->assertEquals(200, $response->response->status());
    }

    /**
     * @dataProvider userprovider
     */
    public function testShouldDeleteUserById($user)
    {
        $user["password"] = "php12345";
        $user["password_confirm"] ="php12345";

        $new_user = $this->json('POST','api/users', $user)->response->getData();

        $api_token = $this->getApiToken($user);
        $url = 'api/users/' . $new_user->id;
        $header = ["api_token" => $api_token];
        $response = $this->delete($url , [], $header);

        $this->assertEquals(200, $response->response->status());
    }

    /**
     * @dataProvider userProvider
     */
    public function testShouldNotDeleteUser($user)
    {
        $user["password"] = "php12345";
        $user["password_confirm"] ="php12345";

        $new_user = $this->json('POST','api/users', $user)->response->getData();

        $api_token = $this->getApiToken($user);
        $url = 'api/users';
        $header = ["api_token" => $api_token];
        $response = $this->delete($url , [
            "id" => $new_user->id
        ], $header);

        $this->assertEquals(405, $response->response->status());

        $url = 'api/users/123' ;
        $response = $this->delete($url , [], $header);
        $this->assertEquals(404, $response->response->status());


    }

    /**
     * @param $user
     * @return mixed
     */
    private function getApiToken($user)
    {
        $response_login = $this->json('POST', '/login', [
            "email" => $user["email"],
            "password" => $user["password"]
        ]);

        return $response_login->response->getData()->api_token;
    }

}
