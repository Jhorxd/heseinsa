<style>
    table tbody tr:hover {
        background-color: #85d2ff;
    }
</style>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">REPORTES DE INICIO DE SESIÓN</div>
        </div>

    </div>
</div>

<div class="mt-4">
    <table class="table" class="fuente8" border="0">
        <thead class="cabeceraTabla">
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Fecha</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
             <?php foreach ($sesiones as $key => $sesion) { ?>
                <?php
                if ($key % 2 == 0) {
                    $clase = 'itemParTabla';
                } else {
                    $clase = 'itemImparTabla';
                }
                $fechaYHoraOriginal = $sesion->SESIC_Fecha;

                // Restar una hora usando strtotime()
                $fechaYHoraMenosUnaHora = date('Y-m-d H:i:s', strtotime($fechaYHoraOriginal . ' -1 hour'));
                ?>
                <tr class="<?= $clase ?>">
                    <td><?= $sesion->SESIC_Usuario; ?></td>
                    <td><?= $sesion->SESIC_Rol; ?></td>
                    <td><?= $fechaYHoraMenosUnaHora; ?></td>
                    <td><?= $sesion->SESIC_Ip; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>