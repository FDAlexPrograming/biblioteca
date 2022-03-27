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

        $validacion = $this->validate([
            'nombre' => 'required|min_length[3]',
            'imagen' =>[
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]'
            ]
        ]);
        if(!$validacion){
            $session = session();
            $session->setFlashdata('mensaje', 'Error al guardar el libro,revise la informacion');
            return redirect()->back()->withInput();
        }
      
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

        $validacion = $this->validate([
            'nombre' => 'required|min_length[3]',
        ]);
        if(!$validacion){
            $session = session();
            $session->setFlashdata('mensaje', 'Error al guardar el libro,revise la informacion');
            return redirect()->back()->withInput();
        }


        $model->update($id, $data);
        $validacion = $this->validate([
            'imagen' => [
                'uploaded[imagen]',
                'max_size[imagen,1024]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]'
            ]
        ]);
        if($validacion){
            if($imagen = $this->request->getFile('imagen')){

                $datosLibro= $model->where('id', $id)->first();
                $rutaImagen = '../public/uploads/'.$datosLibro['imagen'];
                unlink($rutaImagen);

                $nombreRandom = $imagen->getRandomName();
                $imagen->move('../public/uploads', $nombreRandom);
                $data=[
                    'imagen' => $nombreRandom
                ];
                $model->update($id, $data);
            }
        }
        return redirect()->to('listar');
       
    }
}