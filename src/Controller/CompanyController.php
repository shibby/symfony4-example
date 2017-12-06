<?php

namespace App\Controller;

use App\Security\Voter\CompanyVoter;
use App\Services\CompanyMarketService;
use App\Services\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var CompanyMarketService
     */
    private $companyMarketService;

    public function __construct(CompanyService $companyService, CompanyMarketService $companyMarketService)
    {
        $this->companyService = $companyService;
        $this->companyMarketService = $companyMarketService;
    }

    public function updatePricesAction(Request $request, int $companyId, int $companyMarketType)
    {
        $company = $this->companyService->getCompany($companyId);
        if (!$company) {
            return $this->createNotFoundException();
        }
        /*
        * if we would use authentication, i prefer to use Voter's.
        */
        //$this->denyAccessUnlessGranted(CompanyVoter::UPDATE_PRICE, $company);

        $companyMarkets = $this->companyService->getCompanyMarkets($company, $companyMarketType);

        if ($request->isMethod('post')) {
            $prices = (array) $request->request->get('prices');

            foreach ($prices as $companyMarketId => $price) {
                //todo: validate companyMarketId
                //todo: vote companyMarketId
                $this->companyMarketService->updateCompanyMarketPrice($companyMarketId, (float) $price);
                //todo: use transactions
            }

            //$this->addFlash('success', 'Prices updated');

            return $this->redirectToRoute('company_update_prices', [
                'companyMarketType' => $companyMarketType,
                'companyId' => $companyId,
                'updated' => 1, //since sessions are disabled, i'm using query string to give message. old good days.
            ]);
        }

        // replace this line with your own code!
        return $this->render('company/update_prices.html.twig', [
            'company' => $company,
            'companyMarketType' => $companyMarketType,
            'companyMarkets' => $companyMarkets,
        ]);
    }
}
