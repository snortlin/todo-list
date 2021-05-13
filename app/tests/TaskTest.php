<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Faker\Provider\Lorem;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception as HttpClientException;

class TaskTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    private const TASK_TEST_ID = '02d9c13f-9d25-3939-a383-2f2ec705b2f8';

    private Client $client;

    protected function setup(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @throws HttpClientException\ClientExceptionInterface
     * @throws HttpClientException\RedirectionExceptionInterface
     * @throws HttpClientException\ServerExceptionInterface
     * @throws HttpClientException\TransportExceptionInterface
     */
    public function testCreateTask(): void
    {
        $this->client->request('POST', '/api/tasks', [
            'json' => [
                'name' => Lorem::text(255),
                'description' => Lorem::text(),
                'completionDate' => '2021-05-11T12:00:00+02:00',
                'priority' => 1,
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        // + headers assert
        // + response content assert
    }

    /**
     * @throws HttpClientException\TransportExceptionInterface
     * @throws HttpClientException\ServerExceptionInterface
     * @throws HttpClientException\RedirectionExceptionInterface
     * @throws HttpClientException\ClientExceptionInterface
     */
    public function testCreateInvalidTask(): void
    {
        $this->client->request('POST', '/api/tasks', [
            'json' => [
                'name' => '',
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        // + headers assert
        // + response content assert
    }

    /**
     * @throws HttpClientException\ClientExceptionInterface
     * @throws HttpClientException\DecodingExceptionInterface
     * @throws HttpClientException\RedirectionExceptionInterface
     * @throws HttpClientException\ServerExceptionInterface
     * @throws HttpClientException\TransportExceptionInterface
     */
    public function testUpdateTask(): void
    {
        $iri = $this->findIriBy(Task::class, ['id' => self::TASK_TEST_ID]);

        $nameRequestParam = Lorem::text(50);

        $this->client->request('PUT', $iri, [
            'json' => [
                'name' => $nameRequestParam,
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            '@id' => $iri,
            'id' => self::TASK_TEST_ID,
            'name' => $nameRequestParam,
        ]);
    }

    /**
     * @throws HttpClientException\TransportExceptionInterface
     */
    public function testDeleteTask(): void
    {
        $iri = $this->findIriBy(Task::class, ['id' => self::TASK_TEST_ID]);

        $this->client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $this->assertNull(
            static::$container
                ->get(TaskRepository::class)
                ->find(self::TASK_TEST_ID)
        );
    }

    /**
     * @throws HttpClientException\ClientExceptionInterface
     * @throws HttpClientException\RedirectionExceptionInterface
     * @throws HttpClientException\ServerExceptionInterface
     * @throws HttpClientException\TransportExceptionInterface
     */
    public function testGetCollection(): void
    {
        $this->client->request('GET', '/api/tasks');

        $this->assertResponseIsSuccessful();

        // + headers assert
        // + response content assert
    }
}
