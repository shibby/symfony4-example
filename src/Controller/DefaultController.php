<?php

namespace App\Controller;

use App\Services\HomepageService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(HomepageService $homepageService)
    {
        // replace this line with your own code!
        return $this->render('default.html.twig', [
            'companies' => $homepageService->getCompanies(),
        ]);
    }
}
