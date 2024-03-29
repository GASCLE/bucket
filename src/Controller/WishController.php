<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
//        $wish = new Wish();
//
//        $wish->setAuthor("Sly")
//            ->setDateCreated(new \DateTime())
//            ->setTitle("Wish 3")
//            ->setIsPublished(true)
//            ->setDescription("1234564987dfs");
//        $wishRepository->save($wish, true);
        //TODO récupérer la liste des wish et la renvoyer
        //$wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => 'DESC']);
        $wishes = $wishRepository->findPublishWishes();
        dump($wishes);

        return $this->render('/wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        if(!$wish){
            throw $this->createNotFoundException("Oops ! Wish not found !");
        }

        return $this->render('/wish/show.html.twig', [
            'wish' => $wish
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, WishRepository $wishRepository): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){

//            $wish->setDateCreated(new \DateTime());
//            $wish->setIsPublished(true);

            $wishRepository->save($wish, true);
            $this->addFlash("success", "Wish added !");
            return $this->redirectToRoute("wish_show", ['id' => $wish->getId()]);

        }

        return $this->render('/wish/add.html.twig', [
            "wishForm" => $wishForm->createView()
        ]);
    }
















}
