<?php
include_once('models/m_empresa.php');
$objeto = new model_empresa();
$objeto->conectar();
$empresas = $objeto->consultarEmpresas();

$datos = ['vista' => $dataGET[0]];
$permisos = $usuario->permisos($datos);
$objeto->desconectar();
?>

<div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
    <h4 class="text-uppercase font-weight-normal mb-0"><?php echo $titulo; ?></h4>

    <?php if ($permisos['registrar']) { ?>
        <a href="gestion_empresa" class="btn btn-sm btn-info"><i class="fas fa-plus"></i><span class="ml-1">Registrar</span></a>
    <?php } ?>
</div>

<table id="listado" class="table table-bordered table-hover w-100">
    <thead class="">
        <tr class="text-capitalize">
            <th width="80px" class="font-weight-normal">RIF</th>
            <th width="80px" class="font-weight-normal">NIL</th>
            <th class="font-weight-normal">Razón social</th>
            <th width="80px" class="font-weight-normal">Estatus</th>
            <?php if ($permisos['modificar'] OR $permisos['act_desc'] OR $permisos['eliminar']) { ?>
                <th width="75px" class="font-weight-normal p-2"></th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
        <?php
        if ($empresas) {
            foreach ($empresas as $datos) {
        ?>
        <tr class="text-capitalize">
            <td><?php echo $datos['rif']; ?></td>
            <td><?php echo $datos['nil']; ?></td>
            <td><?php echo $datos['razon_social']; ?></td>
            <td class="align-middle text-center">
                <?php if ($datos['estatus'] == 'A') { ?>
                    <span class="badge badge-success"><i class="fas fa-check"></i> Activo</span>
                <?php } else { ?>
                    <span class="badge badge-danger"><i class="fas fa-times"></i> Inactivo</span>
                <?php } ?>
            </td>

            <?php if ($permisos['modificar'] OR $permisos['act_desc'] OR $permisos['eliminar']) { ?>
            <td class="align-middle p-2">
                <?php if ($permisos['modificar']) { ?>
                    <a href="<?php echo 'gestion_empresa/'.$datos['codigo']; ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                <?php } ?>

                <?php
                if ($permisos['act_desc']) {
                    if ($datos['estatus'] == 'A') { ?>
                        <button class="btn btn-sm btn-danger cambiar_estatus" data-codigo="<?php echo $datos['codigo']; ?>" data-estatus="<?php echo $datos['estatus']; ?>"><i class="fas fa-retweet"></i></button>
                    <?php } else { ?>
                        <button class="btn btn-sm btn-success cambiar_estatus" data-codigo="<?php echo $datos['codigo']; ?>" data-estatus="<?php echo $datos['estatus']; ?>"><i class="fas fa-retweet "></i></button>
                    <?php } 
                } ?>
            </td>
            <?php } ?>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>