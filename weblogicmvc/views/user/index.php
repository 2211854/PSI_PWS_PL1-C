<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tabela de users</h3><a href="./?c=user&a=create" class="btn btn-primary float-right">Criar</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-responsive-md">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Nif</th>
                <th>Morada</th>
                <th>Cod. Postal</th>
                <th>Localidade</th>
                <th>Role</th>
                <th>Açoes</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?=$user->id?></td>
                    <td><?=$user->username?></td>
                    <td><?=$user->password?></td>
                    <td><?=$user->email?></td>
                    <td><?=$user->telefone?></td>
                    <td><?=$user->nif?></td>
                    <td><?=$user->morada?></td>
                    <td><?=$user->codigo_postal?></td>
                    <td><?=$user->localidade?></td>
                    <td><?=$user->role?></td>
                    <td>
                        <a href="?c=user&a=edit&id=<?=$user->id?>" class="btn-sm text-decoration-none btn-warning" >Editar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>