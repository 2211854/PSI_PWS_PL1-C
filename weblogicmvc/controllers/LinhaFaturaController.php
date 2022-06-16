<?php
require_once './models/LinhaFatura.php';

class LinhaFaturaController extends BaseAuthController
{
    function index()
    {
        $faturas = Fatura::all();
        $this->renderView('linhaFatura/index',['faturas'=> $faturas ]);
    }

    function create($idFatura,$idProduto)
    {
        $fatura = Fatura::find([$idFatura]);
        $empresa = Empresa::find([1]);
        $linhasFatura = LinhaFatura::find_all_by_fatura_id($idFatura);
        if(is_null($idProduto)){
            $this->renderView('linhaFatura/create',['fatura'=>$fatura,'empresa'=>$empresa,'linhasFatura'=>$linhasFatura]);
        }else{
            $produto = Produto::find([$idProduto]);
            $this->renderView('linhaFatura/create',['fatura'=>$fatura,'empresa'=>$empresa,'linhasFatura'=>$linhasFatura,'produto'=>$produto]);
        }
    }

    function selectProduct($idFatura)
    {
        $fatura = Fatura::find([$idFatura]);
        $produtos = Produto::all();
        $this->renderView('linhaFatura/selectProduct',['fatura'=>$fatura,'produtos'=>$produtos]);
    }

    function store($idFatura,$idProduto)
    {
        $_POST['produto_id']=$idProduto;
        $_POST['fatura_id']=$idFatura;


        if($_POST['quantidade'] != " " )
        {
            $produto = Produto::find([$idProduto]);

            $fatura = Fatura::find([$idFatura]);
            //create new resource (activerecord/model) instance with data from POST
            //your form name fields must match the ones of the table fields
            $linhaFatura = new LinhaFatura($_POST);


            if($linhaFatura->is_valid() && $_POST['quantidade']<$produto->stock){
                $linhaFatura->save();
                //retirar a quantidade do stock do produto
                $stockFinal = $produto->stock-$_POST['quantidade'];
                $arrayProduto =  array('stock'=>$stockFinal);
                $produto->update_attributes($arrayProduto);
                $produto->save();
                //adicionar  o valor unitario * quantidade ao valor total do fatura
                $valorTotal = $fatura->valor_total + ($_POST['valor_unitario'] * $_POST['quantidade']);
                //adicionar  o valor iva * quantidade ao valor iva do fatura
                $ivaTotal = $fatura->iva_total + ($_POST['valor_iva'] * $_POST['quantidade']);
                $arrayFatura =  array('valor_total'=>$valorTotal,'iva_total'=>$ivaTotal);
                $fatura->update_attributes($arrayFatura);
                $fatura->save();

                $this->redirectToRoute('linhaFatura', 'create', ['idFatura' => $idFatura]);
            } else {
                //mostrar vista create passando o modelo como parâmetro
                $this->redirectToRoute('linhaFatura', 'create', ['idFatura' => $idFatura, 'idProduto'=> $idProduto ]);
            }
        }
        else
        {
            $this->redirectToRoute('linhaFatura', 'create', ['idFatura' => $idFatura, 'idProduto'=> $idProduto ]);
        }
    }

    function edit($idLinhaFatura)
    {
        //retirar o valor do produto e do iva da linha fatura a editar dos valores da fatura e depois adicionar no update
        $linhaF = LinhaFatura::find([$idLinhaFatura]);
        $fatura = Fatura::find([$linhaF->fatura_id]);
        $empresa = Empresa::find([1]);
        $linhasFatura = LinhaFatura::find_all_by_fatura_id($linhaF->fatura_id);
        $this->renderView('linhaFatura/edit',['linhaF'=>$linhaF,'empresa'=>$empresa,'linhasFatura'=>$linhasFatura,'fatura'=>$fatura]);
    }

    function update($idLinhaFatura)
    {
        $linhaF = LinhaFatura::find([$idLinhaFatura]);
        $fatura = Fatura::find([$linhaF->fatura_id]);
        $empresa = Empresa::find([1]);
        $linhasFatura = LinhaFatura::find_all_by_fatura_id($linhaF->fatura_id);
        if(($_POST['quantidade'] != " "))
        {
            //find resource (activerecord/model) instance where PK = $id
            //your form name fields must match the ones of the table fields

            $linhaF->update_attributes($_POST);
            if($linhaF->is_valid() && $_POST['quantidade']<$linhaF->produto->stock){
                $linhaF->save();
                //editar a quantidade do stock do produto
                //editar  o valor unitario * quantidade ao valor total do fatura
                //editar  o valor iva * quantidade ao valor iva do fatura
                $this->redirectToRoute('linhaFatura', 'create', ['idFatura' => $linhaF->fatura_id]);
            } else {
                $this->renderView('linhaFatura/edit',['linhaF'=>$linhaF,'empresa'=>$empresa,'linhasFatura'=>$linhasFatura,'fatura'=>$fatura]);
            }
        }
        else
        {
            $this->renderView('linhaFatura/edit',['linhaF'=>$linhaF,'empresa'=>$empresa,'linhasFatura'=>$linhasFatura,'fatura'=>$fatura]);
        }
    }

}
