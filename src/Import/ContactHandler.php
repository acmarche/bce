<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Contact;
use AcMarche\Bce\Repository\ContactRepository;
use AcMarche\Bce\Utils\CsvReader;

class ContactHandler implements ImportHandlerInterface
{
    public function __construct(private readonly ContactRepository $contactRepository, private readonly CsvReader $csvReader)
    {
    }

    public function start(): void
    {
        $this->contactRepository->reset();
    }

    /**
     * @throws \Exception
     */
    public function readFile(string $fileName): iterable
    {
        return $this->csvReader->readCSVGenerator($fileName);
    }

    /**
     * @param Contact $data
     */
    public function writeLn($data): string
    {
        return $data[0];
    }

    /**
     * @param array $data
     */
    public function handle($data): void
    {
        if ('EntityNumber' === $data[0]) {
            return;
        }

        $this->updateContact($data);
    }

    /**
     * "EntityNumber","EntityContact","ContactType","Value".
     */
    private function updateContact(array $data): void
    {
        $contact = new Contact();
        $contact->entityContact = $data[1];
        $contact->entityNumber = $data[0];
        $contact->contactType = $data[2];
        $contact->value = $data[3];
        $this->contactRepository->persist($contact);
    }

    public function flush(): void
    {
        $this->contactRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'contact';
    }
}
