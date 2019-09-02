<?php
namespace App\Tests\Repository;

use App\Entity\WeatherData;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testLastUpdateForExistingCity()
    {
        $data = $this->entityManager
            ->getRepository(WeatherData::class)
            ->findLatest(13);
        ;

        if ($data != null) {
            $this->assertInstanceOf(WeatherData::class, $data);
        }
    }

    public function testLastUpdateForNonExistingCity()
    {
        $data = $this->entityManager
            ->getRepository(WeatherData::class)
            ->findLatest(135555);
        ;

        $this->assertNull($data);
    }



    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}