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
use App\Domain\Commun\Factory\MakerFactory;
use App\Domain\Commun\Factory\PhoneFactory;
use App\Domain\Entity\Phone;

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

    /**
     * @Given I load this phone with maker :
     * @param TableNode $table
     * @throws \Exception
     */
    public function iLoadThisPhoneWithMaker(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $maker = MakerFactory::create($hash['maker']);
            $phone = PhoneFactory::create(
                $hash['name'],
                $hash['description'],
                $hash['price'],
                $hash['stock'],
                $maker
            );

            $this->doctrine->getManager()->persist($phone);
        }
        $this->doctrine->getManager()->flush();
    }

    /**
     * @Given phone with name :arg1 should have following id :arg2
     * @param $phoneName
     * @param $identifierPhone
     * @throws ReflectionException
     */
    public function phoneWithNameShouldHaveFollowingId($phoneName, $identifierPhone)
    {
        $phone = $this->doctrine->getManager()->getRepository(Phone::class)->findOneBy(['name' => $phoneName]);

        if (!$phone) {
            throw new NotFoundHttpException(sprintf('expected phone with name : %s', $phoneName));
        }

        $reflection = new \ReflectionClass($phone);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($phone, $identifierPhone);

        $this->doctrine->getManager()->flush();
    }

    /**
     * @Then the phone with id :phoneId should exist in database
     * @param $phoneId
     */
    public function thePhoneWithIdShouldExistInDatabase($phoneId)
    {
        $phone = $this->doctrine->getManager()->getRepository(Phone::class)->findOneBy(['id' => $phoneId]);

        if (!$phone) {
            throw new NotFoundHttpException(sprintf('Expected phone with id :%s', $phoneId));
        }

    }

    /**
     * @Then the maker with name :name should exist in database
     * @param $name
     */
    public function theMakerWithNameShouldExistInDatabase($name)
    {
        $maker = $this->doctrine->getManager()->getRepository(\App\Domain\Entity\Maker::class)->findOneBy(['name' => $name]);

        if (!$maker) {
            throw new NotFoundHttpException(sprintf('Expected maker with name :%s', $name));
        }
    }

    /**
     * @Given user with email :arg1 should have following id :identifier
     * @param $email
     * @param $identifier
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws ReflectionException
     */
    public function userWithEmailShouldHaveFollowingId($email, $identifier)
    {
        $user = $this->doctrine->getManager()->getRepository(User::class)->findUserByEmail($email);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('Expected user with email : %s', $email));
        }
        $reflection = new \ReflectionClass($user);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($user, $identifier);

        $this->doctrine->getManager()->flush();
    }

    /**
     * @Then user with email :arg1 should not exist in database
     * @parm $email
     * @throws Exception
     */
    public function userWithEmailShouldNotExistInDatabase($email)
    {
        $arrayUser = $this->doctrine->getManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getScalarResult();

        if (count($arrayUser) > 0) {
            throw new \Exception('expected no user', 500 );
        }
    }
}