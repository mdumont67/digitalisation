<?php

namespace App\Controller;

use App\Entity\Axis;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\QuizQuestions;
use App\Form\AxisType;
use App\Form\CategoryType;
use App\Form\ChoiceAxisType;
use App\Form\QuestionType;
use App\Form\QuizType;
use App\Form\SearchCompanyType;
use App\Repository\AxisRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizQuestionsRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quiz', name:'quiz_')]
class QuizController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private AxisRepository $axisRepo,
    private QuizQuestionsRepository $qqRepo){}


    #[Route('/', name: 'index')]
    public function index(){
        
        return $this->render('quiz/index.html.twig',[
        ]);
    }


    #[Route('/list', name: 'list')]
    public function quizList(QuizRepository $quizRepo){
        $quizs = $quizRepo->findBy([]);
        return $this->render('quiz/list.html.twig',[
            'quizs'=> $quizs
        ]);
    }

    #[Route('/choice/{quiz?0}', name:'choice')]
    public function choiceAxis(Quiz $quiz = null, Request $request){
        $axis = null;
        if ($quiz) {
           $id = $quiz->getId();
        }else{
            $id = 0;
        }
        $form = $this->createForm(ChoiceAxisType::class, $axis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $axis = $form->get('axis')->getData();
            return $this->redirectToRoute('quiz_edit', [
                'quiz'=> $id,
                'axis' => $axis->getId()
            ]);
        }
        return $this->render('quiz/choice.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    #[Route('/edit/{quiz?0}/axis/{axis}', name: 'edit')]
    public function edit(Quiz $quiz = null, Request $request, Axis $axis, 
    QuestionRepository $questionRepo, CategoryRepository $categoryRepo): Response
    {
        if (!$quiz) {
            $quiz = new Quiz;
        }
        $oldQqList = $this->qqRepo->findBy(['quiz'=> $quiz]);
        // $oldQqList = $quiz->getQuizQuestions();
        $list = $quiz->getQuestionList();
        $questions = $questionRepo->findAxisQuestions($axis);
        foreach ($questions as $question) {
            if (!array_search($question->getId(), $list)) {
                $qq = new QuizQuestions;
                $qq->setQuestion($question)
                    ->setQuiz($quiz);
                $quiz->addQuizQuestion($qq);
            }
        }
        $qqList = $quiz->getQuizQuestions()->filter(function($element) use($axis) {
            return $element->getQuestion()->getCategory()->getAxis() === $axis;
        }); 
        $form = $this->createForm(QuizType::class, $quiz, ['questions' => $qqList]);
        if ($quiz->getId() !== null) {
            $form->remove('company');
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            foreach ($oldQqList as $qq) {
                $quiz->addQuizQuestion($qq);
                $qq->setQuiz($quiz);
                $this->em->persist($qq);
            }
            // dd($quiz->getQuizQuestions());
            $this->em->persist($quiz);
            $this->em->flush();
            return $this->redirectToRoute('quiz_choice', [
                'quiz' =>$quiz->getId()
            ]);
        }
        
        $categories = $categoryRepo->findBy(['axis'=> $axis]);
        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form'=> $form->createView(),
            'axis'=> $axis,
            'categories'=> $categories,
        ]);
    }

    #[Route('/category/list', name: 'category_list')]
    public function categoryList(CategoryRepository $categoryRepo){
        $categories = $categoryRepo->findBy(['active'=>true]);
        return $this->render('quiz/categoryList.html.twig',[
            'categories'=> $categories
        ]);
    }


    #[Route('/category/{category?0}/edit', name:'category_edit')]
    public function categoryEdit(Category $category = null, Request $request){
        if (!$category) {
            $category = new Category;
        }
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($category);
            $this->em->flush();
            return $this->redirectToRoute('quiz_category_list');
        }
        return $this->render('quiz/categoryEdit.html.twig',[
            'category'=> $category,
            'form'=> $form->createView()
        ]);
    }

    #[Route('/question/list', name: 'question_list')]
    public function questionList(QuestionRepository $questionRepo){
        $questions = $questionRepo->findBy(['active'=>true]);
        return $this->render('quiz/questionList.html.twig',[
            'questions'=> $questions
        ]);
    }


    #[Route('/question/{question?0}/edit', name:'question_edit')]
    public function questionEdit(Question $question = null, Request $request){
        if (!$question) {
            $question = new Question;
        }
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($question);
            $this->em->flush();
            return $this->redirectToRoute('quiz_question_list');
        }
        return $this->render('quiz/questionEdit.html.twig',[
            'question'=> $question,
            'form'=> $form->createView()
        ]);
    }
    #[Route('/axis/list', name: 'axis_list')]
    public function axisList(AxisRepository $axisRepo){
        $axis = $axisRepo->findBy(['active'=>true]);
        return $this->render('quiz/axisList.html.twig',[
            'axis'=> $axis
        ]);
    }


    #[Route('/axis/{axis?0}/edit', name:'axis_edit')]
    public function axisEdit(Axis $axis = null, Request $request){
        if (!$axis) {
            $axis = new Axis;
        }
        $form = $this->createForm(AxisType::class, $axis);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($axis);
            $this->em->flush();
            return $this->redirectToRoute('quiz_axis_list');
        }
        return $this->render('quiz/axisEdit.html.twig',[
            'axis'=> $axis,
            'form'=> $form->createView()
        ]);
    }
    
}
