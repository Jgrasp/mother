<?php

namespace App\EventListener;

use App\Entity\Access;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use ParagonIE\ConstantTime\Hex;
use ParagonIE\Halite\HiddenString;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\Symmetric\Crypto;
use ParagonIE\Halite\Symmetric\EncryptionKey;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessSubscriber implements EventSubscriber
{
    private ParameterBagInterface $parameterBag;

    private SessionInterface $session;

    private LoggerInterface $logger;

    public function __construct(ParameterBagInterface $parameterBag, SessionInterface $session, LoggerInterface $logger)
    {
        $this->parameterBag = $parameterBag;
        $this->session = $session;
        $this->logger = $logger;
    }

    public function getSubscribedEvents(): iterable
    {
        yield Events::prePersist;
        yield Events::preUpdate;
        yield Events::postLoad;
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Access) {
            $this->encryptPassword($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->prePersist($args);
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Access) {
            $this->decryptPassword($entity);
        }
    }

    private function encryptPassword(Access $access): void
    {
        $key = $this->loadKey();

        try {
            $access->setPassword(Crypto::encrypt(new HiddenString($access->getPassword()), $key));

        } catch (\Throwable $e) {
            $this->session->getFlashBag()->add('danger', 'Unable to encrypt field');
            $this->logger->critical(
                'Unable to encrypt password in Access entity. DB update terminated.', array(
                'error' => $e->getMessage(),
            ));
            throw $e;
        }
    }

    private function decryptPassword(Access $access): void
    {
        $key = $this->loadKey();

        try {
            $password = Crypto::decrypt($access->getPassword(), $key);
            $access->setPassword($password->getString());
        } catch (\Throwable $e) {
            $this->session->getFlashBag()->add('warning', 'Unable to decrypt field');
            $this->logger->warning(
                'Unable to decrypt password in Access entity for ID: '.$access->getId(), array(
                'error' => $e->getMessage(),
            ));
        }
    }

    private function loadKey(): EncryptionKey
    {
        $encryptionDirectory = $this->parameterBag->get('encryption_directory');
        $encryptionFile = $encryptionDirectory.'/encryption.key';

        if (!is_readable($encryptionFile)) {
            KeyFactory::save(KeyFactory::generateEncryptionKey(), $encryptionFile);
        }

        try {
            return KeyFactory::loadEncryptionKey($encryptionFile);
        } catch (\Throwable $e) {
            $this->session->getFlashBag()->add('danger', 'Unable to load encryption key!');
            $this->logger->emergency(
                'Unable to lod the encryption key!', array(
                'error' => $e->getMessage(),
            ));
            throw $e;
        }
    }
}