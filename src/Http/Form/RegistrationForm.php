<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 11/03/17
 * Time: 14:03
 */

namespace Komal\prinoo\Http\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationForm extends AbstractType
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var int
     */
    private $noHp;

    /**
     * @var int
     */
    private $jenisKelamin;

    /**
     * @var string
     */
    private $alamat;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            'email',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'firstName',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'lastName',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label'=> false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'noHp',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'jenisKelamin',
            'choice',
            [
                'constraints' => new Assert\NotBlank(),
                'choice_list' => new ChoiceList(
                    ['0','1'],['laki-laki','perempuan']
                ),
                'empty_data' => 0,
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]
        )->add(
            'alamat',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'password',
            'password',
            [
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => ['class'=>'form-control','required'=>'required']
            ]
        )->add(
            'kirim',
            'submit',
            [
                'attr' => ['class'=>'btn btn-primary btn-block'],
                'label' => 'create'
            ]
        );
    }
    
    public function getName()
    {
        return 'registration_form';
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getNoHp()
    {
        return $this->noHp;
    }

    /**
     * @param int $noHp
     */
    public function setNoHp($noHp)
    {
        $this->noHp = $noHp;
    }

    /**
     * @return int
     */
    public function getJenisKelamin()
    {
        return $this->jenisKelamin;
    }

    /**
     * @param int $jenisKelamin
     */
    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = $jenisKelamin;
    }

    /**
     * @return string
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * @param string $alamat
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    

}