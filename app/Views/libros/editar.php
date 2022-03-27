<?=$header?>
    Formulario de 
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ingresa datos del libro</h5>
            <p class="card-text">
                <form method="post" action="<?=base_url('actualizar')?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" value="<?=$libro['nombre']?>" class="form-control" type="text" name="nombre">
                        <input  type="hidden" name="id" value="<?= $libro['id']?>">
                    </div>

                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <br>
                        <img class="img-thumbnail" src="<?=base_url()?>/uploads/<?=$libro['imagen'];?>" width="100" alt="">
                        <br>
                        <br>
                        <input id="imagen" class="form-control-file" type="file" name="imagen">
                        
                    </div>
                    <button class="btn btn-success" type="submit">Editar</button>
                    <a href="<?=base_url('listar')?>" class="btn btn-danger">Cancelar</a>
                </form>
            </p>
        </div>
    </div>

<?=$footer?>
