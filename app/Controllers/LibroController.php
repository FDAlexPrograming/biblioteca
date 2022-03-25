<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;

class LibroController extends Controller{
    
    public function index(){
        $model = new Libro();
        $data['libros'] = $model->orderBy('id', 'ASC')->findAll();
        
        $data['header'] = view('template/header');
        $data['footer'] = view('template/footer');


        return view('Libros/listar', $data);
    }

    public function crearLibro(){
        $data['header'] = view('template/header');
        $data['footer'] = view('template/footer');

        return view('Libros/crear', $data);
    }

    public function guardarLibro(){
        $model = new Libro();
      
        $nombre = $this->request->getVar('nombre');
        if ($imagen = $this->request->getFile('imagen')){
           $nombreRandom = $imagen->getRandomName();
           $imagen->move('../public/uploads', $nombreRandom);
           $data=[
               'nombre' => $nombre,
               'imagen' => $nombreRandom
           ];

        }

        $model->save($data);
        return redirect()->to('listar');
       
    }

   public function eliminarLibro($id=null){
        $model = new Libro();
        $datosLibro= $model->where('id', $id)->first();
        $rutaImagen = '../public/uploads/'.$datosLibro['imagen'];
        unlink($rutaImagen);
        $model->where('id', $id)->delete($id);


        return $this->response->redirect(site_url('listar'));

   }

   public function editarLibro($id=null){
        $model = new Libro();
        $datosLibro= $model->where('id', $id)->first();
        $data['libro'] = $datosLibro;
        $data['header'] = view('template/header');
        $data['footer'] = view('template/footer');

        return view('Libros/editar', $data);
    }

    public function actualizarLibro($id=null){
        $model = new Libro();
        $data=[
            'nombre' => $this->request->getVar('nombre'),
        ];
        $id = $this->request->getVar('id');
        $model->update($id, $data);
       
    }
}