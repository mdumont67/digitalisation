<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\AxisRepository;
use App\Repository\CompanyRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizQuestionsRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
class CompanyController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private QuizRepository $quizRepo,
    private AxisRepository $axisRepo, private QuestionRepository $questionRepo, private QuizQuestionsRepository $qqRepo)
    {
        
    }
    #[Route('/', name: 'list')]
    public function index(CompanyRepository $companyRepo): Response
    {
        $companies = $companyRepo->findBy(['active'=>true]);
        return $this->render('company/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    #[Route('/edit/{company?0}', name: 'edit')]
    public function edit(Company $company = null, Request $request){

        if (!$company) {
            $company = new Company;
        }
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($company);
            $this->em->flush();
            return $this->redirectToRoute('company_list');
        }
        return $this->render('company/edit.html.twig',[
           'company' => $company,
           'form' => $form->createView() 
        ]);
    }

    #[Route('details/{company}', name:'details')]
    public function details(Company $company){

        $quiz = $this->quizRepo->findOneBy(['company' => $company], ['id'=> 'DESC']);
        $axisRating = []; 
        $axisName = [];
        $axis = $this->axisRepo->findAll();
        foreach ($axis as $axe) {
            array_push($axisName, $axe->getLabel());
            $rating = null;
            $nb = 0;
            $questions = $this->questionRepo->findAxisQuestions($axe);
            foreach ($questions as $question) {
                $qq = $this->qqRepo->findOneBy(['quiz'=> $quiz, 'question' => $question]);
                if ($qq) {
                    $rating += $qq->getRating();
                    $nb++;
                }
            }
            if ($nb) {
                $axisRating[$axe->getId()] = floatval(number_format(($rating/$nb), 2 ));
            }
        }
        return $this->render('company/details.html.twig',[
            'company'=> $company,
            'axis'=> $axis,
            'quiz' => $quiz,
            'axisRating' => $axisRating,
            'axisName' => $axisName,
        ]);
    }
}
