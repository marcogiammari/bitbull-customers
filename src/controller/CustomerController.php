<?php

declare(strict_types=1);

namespace BitbullCustomers\Controller;

use BitbullCustomers\Database\CustomerRepository;
use BitbullCustomers\Service\CsvReader;
use BitbullCustomers\Service\Creditsafe\Auth;
use BitbullCustomers\Service\Creditsafe\SearchCompany;
use BitbullCustomers\Model\Customer;
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
