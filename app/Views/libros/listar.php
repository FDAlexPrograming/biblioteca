<?=$header?>
<a href="<?='crear'?>" class="btn btn-primary">Nuevo</a>


        <table class="table table-dark  bg-success">
            <thead class="thead-dark ">
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($libros as $libro):?>

                <tr>
                    <td><?=$libro['id'];?></td>
                    <td><?=$libro['imagen'];?></td>
                    <td><?=$libro['nombre'];?></td>
                    <td><a href="<?=base_url('actualizar/'.$libro['id'])?>" class="btn btn-dark">Editar</a>
                    <a href="<?=base_url('eliminar/'.$libro['id'])?>" class="btn btn-dark">Eliminar</a></td>
                </tr>
                <?php endforeach;?>

            </tbody>
        </table>
<?=$footer?>