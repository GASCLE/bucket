<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => 'DESC']);

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















}
