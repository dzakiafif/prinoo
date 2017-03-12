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

        $controllers->get('/list-user',[$this,'listUserAction'])
            ->before([$this, 'userCredential'])
            ->bind('list_user_admin');

        $controllers->get('/list-order',[$this,'listOrderAction'])
            ->before([$this,'userCredential'])
            ->bind('list_order_admin');

        $controllers->get('/list-barang',[$this,'listBarangAction'])
            ->before([$this,'userCredential'])
            ->bind('list_barang_admin');

        $controllers->get('/delete-user/{id}',[$this,'deleteUserAction'])
            ->before([$this, 'userCredential'])
            ->bind('delete_user_admin');

        $controllers->match('/update-user/{id}',[$this,'editUserAction'])
            ->before([$this, 'userCredential'])
            ->bind('update_user_admin');

        $controllers->match('/create-barang',[$this,'createBarangAction'])
            ->before([$this, 'userCredential'])
            ->bind('create_barang_admin');

        $controllers->get('/delete-barang/{id}',[$this,'deleteBarangAction'])
            ->before([$this, 'userCredential'])
            ->bind('delete_barang_admin');

        $controllers->match('/update-barang/{id}',[$this,'editBarangAction'])
            ->before([$this, 'userCredential'])
            ->bind('update_barang_admin');

        $controllers->match('/profile-user',[$this,'profileUserAdminAction'])
            ->before([$this,'userCredential'])
            ->bind('profile_user_admin');

        return $controllers;
    }

    public function userCredential()
    {
        $email = $this->app['session']->get('email')['value'];
        $data = $this->app['user.repository']->findByEmail($email);

        if ($data->getRole() != 0) {
            return $this->app->redirect($this->app['url_generator']->generate('home'));
        }

        return null;

    }

    public function listOrderAction()
    {
        $orderInfo = $this->app['order.repository']->findAll();

        return $this->app['twig']->render('list.order.twig',['data'=>$orderInfo]);
    }

    public function listUserAction()
    {
        $dataUser = $this->app['user.repository']->findAll();

        return $this->app['twig']->render('list-user.twig',['data'=>$dataUser]);
    }

    public function listBarangAction()
    {
        $barangInfo = $this->app['barang.repository']->findAll();

        return $this->app['twig']->render('admin/list-barang.twig',['data'=>$barangInfo]);
    }

    public function deleteUserAction(Request $request)
    {
        $user = $this->app['user.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();

        return $this->app->redirect('/list-user');
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
            
            return $this->app->redirect('/list-user');
        }
    }

    public function createBarangAction(Request $request)
    {


        if ($request->getMethod() === 'POST') {
            $namaBarang = $request->get('nama-barang');
            $description = $request->get('description');
            $barangProperty = $request->files->get('barang-property');
            $barangChar = json_encode($request->get('barang-char'));

            $filename = md5(uniqid()) . '.' . $barangProperty->guessExtension();


            $data = Barang::create($namaBarang, $description, $filename,$barangChar);
            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            $dirName = $this->app['foto.path'] . '/barang/' . $data->getId();
            $barangProperty->move($dirName, $filename);

            return 'OK';
        }

        return $this->app['twig']->render('barang.twig');
    }

    public function deleteBarangAction(Request $request)
    {
        $barang = $this->app['barang.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($barang);
        $this->app['orm.em']->flush();

        return $this->app->redirect('/list-barang');
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

            return $this->app->redirect('/list-barang');
        }
    }

    public function profileUserAdminAction()
    {
        $dataInfo = $this->app['user.repository']->findByEmail($this->app['session']->get('email')['value']);

        return $this->app['twig']->render('admin/profile-user.twig',['data'=>$dataInfo]);
    }
}