<?php

namespace App\Form;

use App\Entity\LineaOrden;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Producto;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;

class LineaOrdenType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('producto' , EasyAdminAutocompleteType::class, ['class'=> Producto::class, 'attr' =>['css_class'=>'col-sm-3']])
                ->add('precio')
                ->add('cantidad' )
                ->add('orden', HiddenType::class)
              //  ->add('precioTotal' )
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => LineaOrden::class,
        ]);
    }

}
