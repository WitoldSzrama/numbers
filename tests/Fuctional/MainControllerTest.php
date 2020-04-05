<?php


namespace Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Csrf\CsrfToken;

class MainControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;
    /**
     * @var object|null
     */
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->disableReboot();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);

    }

    public function tearDown()
    {
        if ($this->em->getConnection()->isTransactionActive()) {
            $this->em->rollback();
        }

    }

    public function test_index()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function test_post_not_valid()
    {
        $this->getPost(0);

        $this->assertFalse('302' == $this->client->getResponse()->getStatusCode());
    }

    public function test_post_valid()
    {
        $this->getPost(1);
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function getPost($number)
    {
        /** @var CsrfToken $token */
        $token = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('numbers');
        $this->client->request('POST', '/' , ['numbers' =>['inputNumber' => $number, 'submit' => '', '_token' => $token->getValue(),]], [], []);

    }
}