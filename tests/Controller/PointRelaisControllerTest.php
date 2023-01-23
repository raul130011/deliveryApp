<?php

namespace App\Test\Controller;

use App\Entity\PointRelais;
use App\Repository\PointRelaisRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PointRelaisControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PointRelaisRepository $repository;
    private string $path = '/point/relais/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PointRelais::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PointRelai index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'point_relai[adresse]' => 'Testing',
            'point_relai[codePostal]' => 'Testing',
            'point_relai[ville]' => 'Testing',
            'point_relai[pays]' => 'Testing',
            'point_relai[tel]' => 'Testing',
            'point_relai[email]' => 'Testing',
        ]);

        self::assertResponseRedirects('/point/relais/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PointRelais();
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setPays('My Title');
        $fixture->setTel('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PointRelai');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PointRelais();
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setPays('My Title');
        $fixture->setTel('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'point_relai[adresse]' => 'Something New',
            'point_relai[codePostal]' => 'Something New',
            'point_relai[ville]' => 'Something New',
            'point_relai[pays]' => 'Something New',
            'point_relai[tel]' => 'Something New',
            'point_relai[email]' => 'Something New',
        ]);

        self::assertResponseRedirects('/point/relais/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCodePostal());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getPays());
        self::assertSame('Something New', $fixture[0]->getTel());
        self::assertSame('Something New', $fixture[0]->getEmail());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PointRelais();
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');
        $fixture->setPays('My Title');
        $fixture->setTel('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/point/relais/');
    }
}
