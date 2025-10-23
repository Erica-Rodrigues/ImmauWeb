<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\Localisation;
use App\Entity\Photo;
use App\Entity\User;
use App\Repository\BienRepository;
use App\Repository\LocalisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BienController extends AbstractController
{
    #[Route('/bien', name: 'app_bien',methods:['GET'])]
    public function index(BienRepository $bienRepo): JsonResponse
    {
        $biens = $bienRepo->findAll();
        return $this->json($biens);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        //transforme le JSON en tableau associatif
        $data = json_decode($request->getContent(), true);

        // Valide les champs obligatoires (à adapter selon tes besoins)
        $requiredFields = ['nom', 'typeDeBien', 'prix', 'surface', 'nbChambre', 'rue', 'description', 'disponibilite', 'statut', 'localisation'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return $this->json(['error' => "Le champ '$field' est requis"], 400);
            }
        }

        // Récupérer user connecté
        /**
         * @var User
         */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Vous devez être connecté pour créer une annonce'], 401);
        }


        // On récupère la localisation 
        $localisation = $em->getRepository(LocalisationRepository::class)->find($data['localisation']);
        

        // Création du bien
        $bien = new Bien();
        $bien->setNom($data['nom']);
        $bien->setTypeDeBien($data['typeDeBien']);
        $bien->setPrix((float) $data['prix']);
        $bien->setSurface((float) $data['surface']);
        $bien->setNbChambre((int) $data['nbChambre']);
        $bien->setRue($data['rue']);
        $bien->setDescription($data['description']);
        $bien->setDisponibilite(new \DateTime($data['disponibilite']));
        $bien->setStatut($data['statut']);
        $bien->setUser($user);
        $bien->setLocalisation($localisation);

        // Ajout des Photos
        foreach($data['photos'] as $photoId){
            //on récupère l'objet photo à partir de son id
            $photo = $em->getRepository(Photo::class)->find($photoId);
            //on ajoute l'objet à la collection de photos dans bien
            $bien->addPhoto($photo);
        }

        // Persister et flush
        $em->persist($bien);
        $em->flush();

        
        return $this->json([
            'id' => $bien->getId(),
            'nom' => $bien->getNom(),
            'typeDeBien' => $bien->getTypeDeBien(),
            'prix' => $bien->getPrix(),
            'surface' => $bien->getSurface(),
            'nbChambre' => $bien->getNbChambre(),
            'rue' => $bien->getRue(),
            'description' => $bien->getDescription(),
            'disponibilite' => $bien->getDisponibilite()->format('Y-m-d'),
            'statut' => $bien->getStatut(),
            'datePublication' => $bien->getDatePublication()->format('Y-m-d'),
            'user' => $user->getId(),
            'localisation' => $localisation->getId(),
            'photos' => array_map(fn(Photo $p) => $p->getId(), $bien->getPhotos()->toArray())
            // $bien->getPhotos()->toArray() 
            //récupère la collection de photos appartenant au bien et toArray transforme la collection en bien
            //array_map(fn(Photo $p) => $p->getId()
            //applique la fonction fléchée getId à chaque élément du tableaux pour récuperer l'id de chaque photos
        ], 201);
    }

    #[Route('/bien/{id}', name: 'edit_bien', methods: ['PATCH'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Vous devez être connecté pour modifier cette annonce'], 401);
        }

        
        $bien = $em->getRepository(Bien::class)->find($id);
        if (!$bien) {
            return $this->json(['error' => 'Bien introuvable'], 404);
        }

        // Vérifier que l'utilisateur est propriétaire du bien
        if ($bien->getUser() !== $user) {
            return $this->json(['error' => 'Vous ne pouvez pas modifier ce bien'], 403);
        }

        //transforme le JSON en tableau associatif
        $data = json_decode($request->getContent(), true);

        // Mise à jour des données
        if (isset($data['nom'])) $bien->setNom($data['nom']);
        if (isset($data['typeDeBien'])) $bien->setTypeDeBien($data['typeDeBien']);
        if (isset($data['prix'])) $bien->setPrix((float)$data['prix']);
        if (isset($data['surface'])) $bien->setSurface((float)$data['surface']);
        if (isset($data['nbChambre'])) $bien->setNbChambre((int)$data['nbChambre']);
        if (isset($data['rue'])) $bien->setRue($data['rue']);
        if (isset($data['description'])) $bien->setDescription($data['description']);
        if (isset($data['disponibilite'])) $bien->setDisponibilite(new \DateTime($data['disponibilite']));
        if (isset($data['statut'])) $bien->setStatut($data['statut']);
        if (isset($data['localisation'])) {
            $localisation = $em->getRepository(Localisation::class)->find($data['localisation']);
            if ($localisation) {
                $bien->setLocalisation($localisation);
            }
        }
        if (isset($data['photos'])) {
            foreach ($data['photos'] as $photoId) {
                $photo = $em->getRepository(Photo::class)->find($photoId);
                $bien->addPhoto($photo);
            }
        }
        

        // Persister et flush
        $em->persist($bien);
        $em->flush();

        return $this->json([
            'message' => 'Bien mis à jour avec succès',
            'bien' => [
                'id' => $bien->getId(),
                'nom' => $bien->getNom(),
                'typeDeBien' => $bien->getTypeDeBien(),
                'prix' => $bien->getPrix(),
                'surface' => $bien->getSurface(),
                'nbChambre' => $bien->getNbChambre(),
                'rue' => $bien->getRue(),
                'description' => $bien->getDescription(),
                'disponibilite' => $bien->getDisponibilite()->format('Y-m-d'),
                'statut' => $bien->getStatut(),
                'datePublication' => $bien->getDatePublication()->format('Y-m-d'),
                'user' => $user->getId(),
                'localisation' => $bien->getLocalisation()->getId(),
                'photos' => array_map(fn(Photo $p) => $p->getId(), $bien->getPhotos()->toArray())
            ]
        ], 200);
    }


    #[Route('/bien/{id}', name: 'delete_bien', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        // Récupérer user connecté
        /**
         * @var User
         */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Vous devez être connecté pour supprimer cette annonce'], 401);
        }

        $bien = $em->getRepository(Bien::class)->find($id);


        if ($bien->getUser() !== $user) {
            return $this->json(['error' => 'Vous ne pouvez pas supprimer cette annonce'], 403);
        }

        $em->remove($bien);
        $em->flush();

        return $this->json(['message' => 'Annonce supprimée avec succès'], 200);
    }
}
