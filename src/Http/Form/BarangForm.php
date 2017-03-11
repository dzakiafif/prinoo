<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 16:16
 */

namespace Komal\prinoo\Http\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BarangForm extends AbstractType
{

    private $namaBarang;

    private $description;

    private $barangProperty;
    
    private $createdAt;
    
    private $updatedAt;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'namaBarang',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','placeholder'=>'input nama barang','required'=>'required']
            ]
        )->add(
            'description',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label'=>false,
                'attr' => ['class'=>'form-control','placeholder'=>'input description','required'=>'required']
            ]
        )->add(
            'barangProperty',
            'file',
            [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Image([
                        'maxSize' => '1m'
                    ])
                ],
                'attr' => ['class'=>'form-control']
            ]
        )->add(
            'kirim',
            'submit',
            [
                'attr' => ['class'=>'btn btn-primary btn-block'],
                'label' => 'CREATE'
            ]
        );
    }

    public function getName()
    {
        return 'barang_form';
    }

    /**
     * @return mixed
     */
    public function getNamaBarang()
    {
        return $this->namaBarang;
    }

    /**
     * @param mixed $namaBarang
     */
    public function setNamaBarang($namaBarang)
    {
        $this->namaBarang = $namaBarang;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBarangProperty()
    {
        return $this->barangProperty;
    }

    /**
     * @param mixed $barangProperty
     */
    public function setBarangProperty($barangProperty)
    {
        $this->barangProperty = $barangProperty;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    
    
    
    

}