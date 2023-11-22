<?php

declare(strict_types=1);

namespace Controller;

require './src/services/CsvReader.php';
require './src/services/creditsafe/Auth.php';
require './src/services/creditsafe/SearchCompany.php';

use Database\CustomerMySqlRepository;
use Services\CsvReader;
use Services\Creditsafe\Auth;
use Services\Creditsafe\SearchCompany;
use Models\companyData;
use Exception;
use Models\CustomerData;

class CustomerController
{

    public function __construct(
        private CustomerMySqlRepository $customerRepository
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
            $newcompanyData = new CustomerData(
                $companyData['id'],
                $companyData['country'],
                $companyData['name'],
                $companyData['regNo'],
            );

            try {
                $this->customerRepository->save($newcompanyData);
            } catch (Exception $e) {
                throw $e->getMessage();
            }
        }
    }
}
