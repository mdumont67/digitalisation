<?php

namespace App\Controller;

use App\Form\SearchCompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'main_')]
class MainController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(Request $request, CompanyRepository $companyRepo): Response
    {
        $search = null;
        $form = $this->createForm(SearchCompanyType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $search = $form->get('search')->getData();
            if ($search) {
                $companies = $companyRepo->findCompanies($search);
            }else{
                $companies = null;
                $this->addFlash(
                   'error',
                   'Les recherches vides ne sont pas prises en compte'
                );
            }

            return $this->render('main/index.html.twig', [
                'companies' => $companies,
                'form'=> $form->createView()
            ]);
        }
        return $this->render('main/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
