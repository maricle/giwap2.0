<?php

namespace App\EventListener;

use App\Entity\Orden;
use App\Entity\Estadotrabajo;
use App\Repository\EstadotrabajoRepository;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

/**
 * Description of OrdenPaymentNotifier
 *
 * @author maricle
 */
class OrdenNotifier {

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function postPersist(Orden $orden, LifecycleEventArgs $args) {
        # echo 'entra aca';
# die;
        # $entity = $orden->getId();
        if (is_null($orden->getEstadotrabajo())) {
            # $estadoRepo = EstadotrabajoRepository::class;
            ## $estado = $estadoRepo->find(1);
            #$orden->setEstadotrabajo($estado);
        }
        $orden->setUser($this->security->getUser());
        $orden->updateSaldo();
        $em = $args->getObjectManager();
        $em->persist($orden);
        $em->flush();

        #   }
        // only act on some "Product" entity
        #    if (!$entity instanceof Orden) {
        ##     }
        //       $entityManager = $args->getObjectManager();
        //busco el pago asociado y actualizo el registro del pago
//        $em = $this->getDoctrine()->getManagerForClass(Orden::class);
//        $repository=$this->getDoctrine()->getRepository(Orden::class);
//        
//        $orden = $pago->getOrden();
//        
//        $orden->actualizarPago();
//        $em->persist($orden);
//        $em->flush();
    }

    public function postUpdate(Orden $orden, LifecycleEventArgs $args) {

        if (is_null($orden->getUser())) {
            $orden->setUser($this->security->getUser());
        }
        $orden->updateSaldo();
        $em = $args->getObjectManager();
        $em->persist($orden);
        $em->flush();
    }

}
