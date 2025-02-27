<?php

namespace App\Form;

use App\Entity\Playlist;
use App\Entity\Cancion;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre de la Playlist',
                'attr' => ['class' => 'form-control']
            ])
            ->add('visibilidad', ChoiceType::class, [
                'choices' => [
                    'Privado' => 'privado',
                    'Público' => 'publico'
                ],
                'label' => 'Visibilidad',
                'attr' => ['class' => 'form-control']
            ])
            ->add('likes', IntegerType::class, [
                'label' => 'Likes iniciales',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'data' => 0
            ])
            ->add('portada', UrlType::class, [
                'label' => 'URL de la imagen de portada',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://ejemplo.com/imagen.jpg'
                ]
            ])
            ->add('canciones', EntityType::class, [
                'class' => Cancion::class,
                'choice_label' => 'titulo', // Asumiendo que tu entidad Cancion tiene un campo 'titulo'
                'multiple' => true,         // Permite seleccionar múltiples canciones
                'expanded' => true,         // Muestra como checkboxes (cambia a false para un select múltiple)
                'mapped' => false,          // No está directamente mapeado a la entidad Playlist
                'required' => false,
                'label' => 'Selecciona canciones para esta playlist',
                'attr' => ['class' => 'form-control checkbox-list']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
}
