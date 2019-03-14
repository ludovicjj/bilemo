<?php

use Behat\Behat\Context\Context;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Persistence\ObjectManager;
use App\Domain\Commun\Factory\ClientFactory;
use Behat\Gherkin\Node\TableNode;
use App\Domain\Entity\Client;
use App\Domain\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use App\Domain\Commun\Factory\UserFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class DoctrineContext implements Context
{
    private $schemaTool;

    /** @var RegistryInterface  */
    private $doctrine;

    /** @var KernelInterface  */
    private $kernel;

    /** @var EncoderFactoryInterface  */
    private $encoderFactory;

    public function __construct(
        RegistryInterface $doctrine,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    )
    {
        $this->doctrine = $doctrine;
        $this->kernel = $kernel;
        $this->schemaTool = new SchemaTool($this->doctrine->getManager());
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function clearDatabase()
    {
        $this->schemaTool->dropSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
        $this->schemaTool->createSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }


    /**
     * @param string $classEncoder
     *
     * @return PasswordEncoderInterface
     */
    private function getEncoder(string $classEncoder)
    {
        return $this->encoderFactory->getEncoder($classEncoder);
    }

    /**
     * @Given I load the following client :
     * @param TableNode $table
     * @throws Exception
     */
    public function ILoadTheFollowingUser(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $user = ClientFactory::create(
                $hash['username'],
                $this->getEncoder(Client::class)->encodePassword($hash['password'], ''),
                $hash['email']
            );
            $this->getManager()->persist($user);
        }
        $this->getManager()->flush();
    }

    /**
     * @Then the client :username should exist in database
     *
     * @param $username
     * @throws NonUniqueResultException
     * @throws NotFoundHttpException
     */
    public function theClientShouldExistInDatabase($username)
    {
        $client = $this->doctrine->getManager()->getRepository(Client::class)
            ->createQueryBuilder('c')
            ->where('c.username = :client_username')
            ->setParameter('client_username', $username)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$client) {
            throw new NotFoundHttpException(sprintf('Aucun client ne correspond au username : %s', $username));
        }
    }

    /**
     * @Then the user with email :email should exist in database
     * @param $email
     * @throws NonUniqueResultException
     * @throws NotFoundHttpException
     */
    public function theUserShouldExistInDatabase2($email)
    {
        $user = $this->doctrine->getManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
        if (!$user) {
            throw new NotFoundHttpException(sprintf('Expected user with email :%s', $email));
        }
    }

    /**
     * @Given client have the following user:
     * @param TableNode $table
     * @throws NonUniqueResultException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function clientHaveTheFollowingUser(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $client = $this->doctrine->getManager()->getRepository(Client::class)
                ->createQueryBuilder('c')
                ->where('c.username = :client_username')
                ->setParameter('client_username', $hash['client'])
                ->getQuery()
                ->getOneOrNullResult();

            if (!$client) {
                throw new NotFoundHttpException(sprintf('Expected client with username :%s', $hash['client']));
            }

            $user = UserFactory::create(
                $hash['firstName'],
                $hash['lastName'],
                (string) $hash['phoneNumber'],
                $hash['email'],
                $client
            );
            $this->doctrine->getManager()->persist($user);
        }
        $this->doctrine->getManager()->flush();
    }

    /**
     * @Given client with username :username should have following id :identifier
     * @param $username
     * @param $identifier
     * @throws ReflectionException
     */
    public function clientWithUsernameShouldHaveFollowingId($username, $identifier)
    {
        $client = $this->doctrine->getManager()->getRepository(Client::class)->findOneBy(['username' => $username ]);

        if (!$client) {
            throw new NotFoundHttpException(sprintf('Expected client with username :%s', $username));
        }

        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($client, $identifier);

        $this->doctrine->getManager()->flush();
    }

    /**
     * @Given I load fixtures with the following command :command
     * @param $command
     * @throws Exception
     */
    public function iLoadFixturesWithTheFollowingCommand($command)
    {
        $application = new Application($this->kernel);

        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => $command,
            '--no-interaction' => true,
        ]);
        $output = new \Symfony\Component\Console\Output\NullOutput();
        $application->run($input, $output);
    }
}