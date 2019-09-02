<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie as SymfonyCookie;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client = null;

    protected function setUp()
    {
        $this->client = static::createClient();


    }
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('test@test.com', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new SymfonyCookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testWeCanAccessHomeAdminPage()
    {
        $this->login();
        $crawler = $this->client->request('GET', '/admin');
        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }


    public function testSearchForExistingCity()
    {
        $this->login();
        $crawler = $this->client->request('GET', '/admin/add');
        $response = $this->client->getResponse();
        $form = $crawler->selectButton('Search for city')->form();

        $form['form[name]']->setValue('Athens');
        $this->client->submit($form);
        $this->assertContains(
    	    '5178651',
    	    $this->client->getResponse()->getContent()
	    );
    }

    public function testSearchForNonExistingCity()
    {
        $this->login();
        $crawler = $this->client->request('GET', '/admin/add');
        $response = $this->client->getResponse();
        $form = $crawler->selectButton('Search for city')->form();

        $form['form[name]']->setValue('Neexistuje');
        $this->client->submit($form);
        $this->assertContains(
    	    'City not found',
    	    $this->client->getResponse()->getContent()
	    );
    }

    public function testForSuccesfulCityAdd()
    {
        $this->login();
        $this->client->request('POST', '/admin/insert',
            ['coord' => '{"lon":37.615555,"lat":55.75222}',
                'name'  => 'Moscow',
                'id' => '524901',
                'country' => 'RU',
                'save' => 'save'
            ])
        ;
        if ($this->client->getResponse()->isRedirection()) {
            $this->client->followRedirect();
        }
         $this->assertContains(
    	    'Moscow',
    	    $this->client->getResponse()->getContent()
	    );

    }


}

