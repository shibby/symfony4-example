<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyMarket;
use App\Form\CompanyType;
use App\Security\Voter\CompanyVoter;
use App\Services\CompanyMarketService;
use App\Services\CompanyService;
use App\Services\MarketService;
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
    /**
     * @var MarketService
     */
    private $marketService;

    public function __construct(
        CompanyService $companyService,
        CompanyMarketService $companyMarketService,
        MarketService $marketService
    ) {
        $this->companyService = $companyService;
        $this->companyMarketService = $companyMarketService;
        $this->marketService = $marketService;
    }

    public function updatePricesAction(Request $request, int $companyId, ?int $companyMarketType)
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
                //todo: validate companyMarketIds are correct
                $companyMarket = $this->companyMarketService->getCompanyMarket($companyMarketId);
                if ($companyMarket) {
                    //todo: vote is user allowed to update companyMarket
                    $this->companyMarketService->updateCompanyMarketPrice($companyMarket, (float) $price);
                }

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

    public function createCompanyAction(Request $request)
    {
        $markets = $this->marketService->getMarkets();

        $form = $this->createForm(CompanyType::class, null, [
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $company = $this->companyService->createCompany($data['name']);

            $this->companyMarketService->addStocks($company, $data['stocks']);

            return $this->redirectToRoute('company_update_prices', [
                'companyId' => $company->getId(),
                'companyMarketType' => null,
            ]);
        }

        return $this->render('company/create.html.twig', [
            'form' => $form->createView(),
            'markets' => $markets,
            'stockTypes' => CompanyMarket::TYPES,
        ]);
    }
}
