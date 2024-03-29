<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Address;
use AcMarche\Bce\Repository\AddressRepository;
use AcMarche\Bce\Utils\CsvReader;

class AddressHandler implements ImportHandlerInterface
{
    public function __construct(private readonly AddressRepository $addressRepository, private readonly CsvReader $csvReader)
    {
    }

    public function start(): void
    {
    }

    /**
     * @throws \Exception
     */
    public function readFile(string $fileName): array
    {
        return $this->csvReader->readCSVGenerator($fileName);
    }

    /**
     * @param array $data
     */
    public function handle($data): void
    {
        if ('EntityNumber' === $data[0]) {
            return;
        }

        if (!($address = $this->addressRepository->checkExist($data[0], $data[4])) instanceof Address) {
            $address = new Address();
            $address->entityNumber = $data[0];
            $address->zipcode = $data[4];
            $this->addressRepository->persist($address);
        }

        $this->updateAddress($address, $data);
    }

    /**
     * "EntityNumber","TypeOfAddress","CountryNL","CountryFR","Zipcode","MunicipalityNL","MunicipalityFR","StreetNL","StreetFR",
     * "HouseNumber","Box","ExtraAddressInfo","DateStrikingOff".
     */
    private function updateAddress(Address $address, array $data): void
    {
        $address->typeOfAddress = $data[1];
        $address->countryNL = $data[2];
        $address->countryFR = $data[3];
        $address->municipalityNL = $data[5];
        $address->municipalityFR = $data[6];
        $address->streetNL = $data[7];
        $address->streetFR = $data[8];
        $address->houseNumber = $data[9];
        $address->box = $data[10];
        $address->extraAddressInfo = $data[11];
        $address->dateStrikingOff = $data[12];
    }

    /**
     * @param array $data
     */
    public function writeLn($data): string
    {
        return $data[0];
    }

    public function flush(): void
    {
        $this->addressRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'address';
    }
}
