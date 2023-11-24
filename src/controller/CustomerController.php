<?php

declare(strict_types=1);

namespace Controller;

require './src/service/CsvReader.php';
require './src/service/creditsafe/Auth.php';
require './src/service/creditsafe/SearchCompany.php';
require './src/model/Customer.php';

use Database\CustomerRepository;
use Service\CsvReader;
use Service\Creditsafe\Auth;
use Service\Creditsafe\SearchCompany;
use Model\Customer;
use Exception;

class CustomerController
{

    public function __construct(
        private CustomerRepository $customerRepository
    ) {
    }

    public function saveRandomFromCsv($path): void
    {
        $fileContent = CsvReader::getContentAsArray($path);

        $randomVat = $fileContent[rand(0, count($fileContent) - 1)];

        $accessToken = Auth::authenticate();

        $searchData = SearchCompany::byVat($accessToken, $randomVat);

        $companiesData = $searchData['companies'];

        foreach ($companiesData as $companyData) {
            $newCustomer = new Customer(
                $companyData['id'],
                $companyData['country'],
                $companyData['name'],
                $companyData['regNo'],
                $randomVat,
                array_values($companyData['address'])
            );

            if (isset($companyData['phoneNumbers']) && count($companyData['phoneNumbers']) > 0) {
                $newCustomer->addPhoneNumbers($companyData['phoneNumbers']);
            }

            try {
                $this->customerRepository->save($newCustomer);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}
