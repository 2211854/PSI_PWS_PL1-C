<div class="card">
    <div class="card-header">
        <h1 class="card-title m-0">Tabela de Faturas</h1><a href="./?c=fatura&a=create" class="btn btn-primary float-right">Criar</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-responsive-md">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Data</th>
                <th>Valor total</th>
                <th>Iva total</th>
                <th>Subtotal</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Funcionario</th>
                <th>Açoes</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($faturas as $fatura) {
                ?>
                <tr>
                    <td><?=$fatura->id?></td>
                    <td><?= date_format($fatura->data, 'Y/m/d H:i:s') ?></td>
                    <td>€ <?= number_format($fatura->valor_total,2)?></td>
                    <td>€ <?= number_format($fatura->iva_total,2)?></td>
                    <td>€ <?= number_format(($fatura->iva_total+$fatura->valor_total),2)?></td>
                    <td><?=$fatura->estado?></td>
                    <!--provavelmente vou fazer o find do cliente e do funcionario para mostrar o username do mesmo -->
                    <td><?=$fatura->cliente->username?></td>
                    <td><?=$fatura->user->username?></td>
                    <td>
                        <?php  if($fatura->estado == 'em processamento' && $_SESSION['role'] !='Cliente'){ ?>
                        <a href="?c=linhaFatura&a=create&idFatura=<?=$fatura->id?>" class="btn-sm text-decoration-none btn-warning" ><i class="fa-solid fa-pen-to-square"></i></a>
                        <?php }elseif($fatura->estado == 'emitida'){?>
                            <a href="?c=fatura&a=show&idFatura=<?=$fatura->id?>" class="btn-sm text-decoration-none btn-success" ><i class="fa-solid fa-eye"></i></a>
                        <?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>