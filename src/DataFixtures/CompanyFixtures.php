<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = $this->getDummyData();

        $i = 1;
        foreach ($data as $datum) {
            $company = new Company();
            $company->setName($datum['name']);

            $manager->persist($company);
            if ($i < 3) {
                //for first 2 company, i'm adding them as reference to use future
                $manager->flush();
                $this->addReference('company_'.$i, $company);
            }
            ++$i;
        }
        $manager->flush();
    }

    private function getDummyData(): array
    {
        return [
            [
                'name' => 'kiveo AG',
            ],
            [
                'name' => 'Metadeo AG',
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
        ];
    }
}
