<?php

namespace App\Form;

use App\Entity\Orden;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
 

class OrdenType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
       
        
       
        $builder
                ->add('fecha')
                ->add('prioridad')
                ->add('nombre')
                ->add('descripcion')
                ->add('cantidad')
                ->add('medida_trabajo')
                ->add('papel')
                ->add('color')
                ->add('precio')               
                ->add('baja')
                ->add('numeracion')
                ->add('entrega')
                ->add('sucursal')
                ->add('saldo')
                ->add('estadotrabajo')
                ->add('persona')
                ->add('puntodeventa')
                ->add('created_at',  HiddenType::class)
                ->add('updated_at', HiddenType::class)
        ;


        $builder->add('lineas', CollectionType::class, [
            'linea_orden_type' => LineaOrdenType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete'=> true,
        ]);
        $builder->add('pagos', CollectionType::class, [
            'linea_orden_type' => PagoType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete'=>true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Orden::class,
        ]);
    }

}
