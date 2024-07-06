<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ContactForm;

class MainController extends AbstractController
{
    private $validator;
    private $entityManager;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/api/contact-form', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $contactForm = new ContactForm();
        $contactForm->setFirstname(trim($data['firstname']));
        $contactForm->setLastname(trim($data['lastname']));
        $contactForm->setEmail(trim($data['email']));
        $contactForm->setMessage(trim($data['message']));

        $errors = $this->validator->validate($contactForm);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage() ." (". $error->getPropertyPath().")";
            }
            return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($contactForm);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Formularz został pomyślnie przesłany!',
            'data' => [
                'firstname' => $contactForm->getFirstname(),
                'lastname' => $contactForm->getLastname(),
                'email' => $contactForm->getEmail(),
                'message' => $contactForm->getMessage(),
            ]
        ]);
    }
}
  

