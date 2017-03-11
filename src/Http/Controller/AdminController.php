<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 15:54
 */

namespace Komal\prinoo\Http\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Komal\prinoo\Domain\Entity\Barang;
use Komal\prinoo\Domain\Entity\User;
use Komal\prinoo\Http\Form\BarangForm;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{

    private $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/list-user',[$this,'listUserAction']);

        $controllers->get('/delete-user/{id}',[$this,'deleteUserAction']);

        $controllers->match('/update-user/{id}',[$this,'editUserAction']);

        $controllers->match('/create-barang',[$this,'createBarangAction']);

        $controllers->get('/delete-barang/{id}',[$this,'deleteBarangAction']);

        $controllers->match('/update-barang/{id}',[$this,'editBarangAction']);

        $controllers->get('/credent', [$this, 'userCredential']);

        return $controllers;
        // TODO: Implement connect() method.
    }

    public function userCredential()
    {
        $email = $this->app['session']->get('email')['value'];
        $data = $this->app['user.repository']->findByEmail($email);

        return var_dump($data->getRole());

    }

    public function listUserAction()
    {
        $dataUser = $this->app['user.repository']->findAll();

        if($dataUser != null){
            echo 'SUKSES';
        }else {
            echo 'GAGAL';
        }

        return $this->app['twig']->render('list-user.twig');
    }
    public function deleteUserAction(Request $request)
    {
        $user = $this->app['user.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();

        return 'data berhasil dihapus';
    }

    public function editUserAction(Request $request)
    {
        $userInfo = $this->app['user.repository']->findById($request->get('id'));

        if($request->getMethod() === 'GET'){
            return $this->app['twig']->render('update-user.twig',['data'=>$userInfo]);
        }
        
        if($request->getMethod() === 'POST'){
            $kampret = $this->app['orm.em']->getRepository('Komal\prinoo\Domain\Entity\User')->findById($request->get('id'));
            if($kampret instanceof User){
                $kampret->setId($request->get('id'));
                $kampret->setEmail($request->get('email'));
                $kampret->setFirstName($request->get('first-name'));
                $kampret->setLastName($request->get('last-name'));
                $kampret->setNoHp($request->get('no-hp'));
                $kampret->setJenisKelamin($request->get('jenis-kelamin'));
                $kampret->setAlamat($request->get('alamat'));
                $kampret->setPassword($request->get('password'));
                $kampret->setCreatedAt(new \DateTime());
                $kampret->setUpdatedAt(new \DateTime());
            }

            $this->app['orm.em']->flush();
            
            return 'Data berhasil di Update';
        }
    }

    public function createBarangAction(Request $request){
        $barang = new BarangForm();
        $formBuilder = $this->app['form.factory']->create($barang,$barang);

        if($request->getMethod() == 'GET'){
            return $this->app['twig']->render('barang.twig',['form'=>$formBuilder->createView()]);
        }

        $formBuilder->handleRequest($request);

        if(!$formBuilder->isValid()){
            return $this->app['twig']->render('barang.twig',['form'=>$formBuilder->createView()]);
        }
        $files = $barang->getBarangProperty();
        $fileName = md5(uniqid()). '.' . $files->guessExtension();

        $data = Barang::create($barang->getNamaBarang(),$barang->getDescription(),$fileName);
        $this->app['orm.em']->persist($data);
        $this->app['orm.em']->flush();

        $dirName = $this->app['foto.path'] . '/barang/' . $data->getId();


        if(is_dir($dirName) == false){
            mkdir($dirName,0755);
        }
        $files->move($dirName, $fileName . '.' . $files->guessExtension());

        return 'OK';
    }

    public function deleteBarangAction(Request $request)
    {
        $barang = $this->app['barang.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($barang);
        $this->app['orm.em']->flush();

        return 'data berhasil di delete';
    }

    public function editBarangAction(Request $request)
    {
        $barangInfo = $this->app['barang.repository']->findById($request->get('id'));

        if($request->getMethod() == 'GET'){
            return $this->app['twig']->render('update-barang.twig',['data'=>$barangInfo]);
        }

        if($request->getMethod() == 'POST'){

            $kampret = $this->app['orm.em']->getRepository('Komal\prinoo\Domain\Entity\Barang')->findById($request->get('id'));
            $files = $request->files->get('barang-property');
            $fileName = md5(uniqid(). '.'.$files->guessExtension());
            if($kampret instanceof Barang){
                $kampret->setId($request->get('id'));
                $kampret->setNamaBarang($request->get('nama-barang'));
                $kampret->setDescription($request->get('description'));
                $kampret->setBarangProperty($fileName);
                $kampret->setCreatedAt(new \DateTime());
                $kampret->setUpdatedAt(new \DateTime());
            }

            $this->app['orm.em']->flush();

            $dirName = $this->app['foto.path'] . '/barang/' . $kampret->getId();

            if(is_dir($dirName) == false){
                mkdir($dirName,0755);
            }

            $files->move($dirName,$fileName . '.' . $files->guessExtension());

            return 'data berhasil di update';
        }
    }
}