<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'quiz:item']),
        new GetCollection(normalizationContext: ['groups' => 'quiz:list'])
    ],
    order: ['id' => 'DESC'],
    paginationEnabled: false,
)]
#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['quiz:list', 'quiz:item'])]
    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[Groups(['quiz:list', 'quiz:item'])]
    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: QuizQuestions::class, cascade:['persist', 'refresh'])]
    private Collection $quizQuestions;

    #[Groups(['quiz:list', 'quiz:item'])]
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'quizzes')]
    private Collection $categories;

    public function __construct()
    {
        $this->quizQuestions = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestions>
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestions $quizQuestion): self
    {
        if (!$this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions->add($quizQuestion);
            $quizQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestions $quizQuestion): self
    {
        if ($this->quizQuestions->removeElement($quizQuestion)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestion->getQuiz() === $this) {
                $quizQuestion->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getQuestionList(){
        $questionList = [];
        foreach ($this->quizQuestions as $quizQuestion) {
            array_push($questionList, $quizQuestion->getQuestion()->getId());
        }
        return $questionList;
    }
}
