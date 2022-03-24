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

   public function eliminarLibro($id){
        $model = new Libro();
        $model->delete($id);
        return redirect()->to('listar');
   }

    public function actualizarLibro($id){
          $model = new Libro();
          $data['libro'] = $model->find($id);
          $data['header'] = view('template/header');
          $data['footer'] = view('template/footer');
    
          return view('Libros/actualizar', $data);
    }
}