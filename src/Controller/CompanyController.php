<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Stock;
use App\Form\CompanyType;
use App\Security\Voter\CompanyVoter;
use App\Services\StockService;
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
     * @var StockService
     */
    private $stockService;

    /**
     * @var MarketService
     */
    private $marketService;

    public function __construct(
        CompanyService $companyService,
        StockService $stockService,
        MarketService $marketService
    ) {
        $this->companyService = $companyService;
        $this->stockService = $stockService;
        $this->marketService = $marketService;
    }

    public function updatePricesAction(Request $request, int $companyId, ?int $stockType)
    {
        $company = $this->companyService->getCompany($companyId);
        if (!$company) {
            return $this->createNotFoundException();
        }
        /*
        * if we would use authentication, i prefer to use Voter's.
        */
        //$this->denyAccessUnlessGranted(CompanyVoter::UPDATE_PRICE, $company);

        $stocks = $this->companyService->getStocks($company, $stockType);

        if ($request->isMethod('post')) {
            $prices = (array) $request->request->get('prices');

            foreach ($prices as $stockId => $price) {
                //todo: validate stockIds are correct
                $stock = $this->stockService->getStock($stockId);
                if ($stock) {
                    //todo: vote is user allowed to update stock
                    $this->stockService->updateStockPrice($stock, (float) $price);
                }

                //todo: use transactions
            }

            //$this->addFlash('success', 'Prices updated');

            return $this->redirectToRoute('company_update_prices', [
                'stockType' => $stockType,
                'companyId' => $companyId,
                'updated' => 1, //since sessions are disabled, i'm using query string to give message. old good days.
            ]);
        }

        // replace this line with your own code!
        return $this->render('company/update_prices.html.twig', [
            'company' => $company,
            'stockType' => $stockType,
            'stocks' => $stocks,
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

            $this->stockService->addStocks($company, $data['stocks']);

            return $this->redirectToRoute('company_update_prices', [
                'companyId' => $company->getId(),
                'stockType' => null,
            ]);
        }

        return $this->render('company/create.html.twig', [
            'form' => $form->createView(),
            'markets' => $markets,
            'stockTypes' => Stock::TYPES,
        ]);
    }
}
