<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Utils\Utils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
     * @Route("/signup", name="signup", methods={"POST"})
     *
     */
    public function signup(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if(empty($data['firstName']) || empty($data['lastName']) || empty($data['email']) || empty($data['password']) )
            return $this->json(Utils::errorResponse($request->getUri(), 404, 'Certains paramètres sont manquants.'));

        $user = new User();

        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);

        try
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json(Utils::httpResponse('url', 200,  $user)); //; new JsonResponse(['status' => 'OK', 'user' => $user->getEmail()], Response::HTTP_CREATED);
        }
        catch(\Exception $ex)
        {
            return $this->json(Utils::errorResponse($request->getUri(), 400, $ex->getMessage()));
        }
        
       
        
    }

    /**
     * @Route("/user/{id}", name="find_user", methods={"GET"})
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function findUserById(Request $request, string $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)
                                    ->find($id);

        return $this->json(Utils::httpResponse($request->getUri(), 200, $user));
    }

    /**
     * @Route("/all", name="all", methods={"GET"})
     *
     * @param Request $request
     * @return void
     */
    public function findAll(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)
                                     ->findAll();

        return $this->json(Utils::httpResponse($request->getUri(), 200, $users));
    }

    /**
     * @Route("/user/{id}", name="delete_user", methods={"DELETE"})
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function deleteUser(Request $request, string $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)
                                    ->find($id);

        $manager = $this->getDoctrine()->getManager();

        try
        {
            $manager->remove($user);
            $manager->flush();
            return $this->json(Utils::httpResponse($request->getUri(), 200, $user));
        }
        catch(\Exception $ex)
        {
            return $this->json(Utils::errorResponse($request->getUri(), 400, $ex->getMessage()));
        }
                
    }

    /**
     * @Route("/user/{id}", name="update_user", methods={"PUT"})
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function updateUser(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);        

        $doctrine = $this->getDoctrine();
        $user = $doctrine->getRepository(User::class)
                         ->find($id);


        if(!empty($data['firstName']))
            $user->setFirstName($data['firstName']);

        if(!empty($data['lastName']))
            $user->setLastName($data['lastName']);

        if(!empty($data['email']))
            $user->setEmail($data['email']);
                
        
        try
        {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->json(Utils::httpResponse($request->getUri(), 200, $user));
        }
        catch(\Exception $ex)
        {
            return $this->json(Utils::errorResponse($request->getUri(), 400, $ex->getMessage()));
        }
                
    }
}
