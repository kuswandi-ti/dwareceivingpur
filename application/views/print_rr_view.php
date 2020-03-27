<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .rrr_square {
        border: 1px solid black;
        padding: 10px;
        width: 97%;
    }
</style>

<div class="rrr_square">
    <img src="assets/img/logo-dwa.jpg">
    <h4 style="text-align: center;"><u>SERAH TERIMA BARANG (REQUESTER)</u></h4>

    <?php
        if (!empty($data_header)) {
            $row = $data_header->row();
    ?>
            <table cellspacing="3" style="font-size: 80%">
                <tr>
                    <td style="width:90px">No. RRR</td>
                    <td style="width:10px">:</td>
                    <td style="width:230px"><?php echo $row->Doc_No; ?></td>

                    <td style="width:10px">&nbsp;</td>

                    <td style="width:90px">No. PO</td>
                    <td style="width:10px">:</td>
                    <td style="width:230px"><?php echo $row->Doc_PO; ?></td>
                </tr>

                <tr>
                    <td style="width:90px">Tgl RRR</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo date_format(new DateTime($row->Doc_Date), $this->config->item('FORMAT_DATE_TO_DISPLAY')); ?></td>

                    <td style="width:10px">&nbsp;</td>

                    <td style="width:90px">No. CERQ/BPPQ</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo $row->Doc_BPPCER; ?></td>
                </tr>

                <tr>
                    <td style="width:90px">No. SJ</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo $row->Doc_SJ; ?></td>

                    <td style="width:10px">&nbsp;</td>

                    <td style="width:90px">No. CER/BPP</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo $row->R_No; ?></td>
                </tr>

                <tr valign="top">
                    <td style="width:90px">Tgl SJ</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo date_format(new DateTime($row->Date_SJ), $this->config->item('FORMAT_DATE_TO_DISPLAY')); ?></td>

                    <td style="width:10px">&nbsp;</td>

                    <td style="width:90px">Supplier</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo $row->V_CN; ?></td>
                </tr>

                <tr>
                    <td style="width:90px">No. RCV</td>
                    <td style="width:10px">:</td>
                    <td style="width:180px"><?php echo $row->Doc_RRPUR; ?></td>

                    <td style="width:10px">&nbsp;</td>

                    <td style="width:90px">&nbsp;</td>
                    <td style="width:10px">&nbsp;</td>
                    <td style="width:180px">&nbsp;</td>
                </tr>
            </table>
    <?php
        }
    ?>

    <br>

    <table style="border: 1px solid black; border-collapse: collapse; font-size: 80%; table-layout: fixed;">
        <tr>    
            <td style="border: 1px solid black; width: 5%; text-align: center; padding: 10px;"><b>No</b></td>
            <td style="border: 1px solid black; width: 45%; padding: 10px;"><b>Nama Barang</b></td>
            <td style="border: 1px solid black; width: 10%; text-align: center; padding: 10px;"><b>Satuan</b></td>
            <td style="border: 1px solid black; width: 8%; text-align: right; padding: 10px;"><b>Jumlah</b></td>
            <td style="border: 1px solid black; width: 32%; padding: 10px;"><b>Keterangan</b></td>
        </tr>
        <?php
            if(!empty($data_detail)) {
                $no = 1;
                foreach($data_detail as $data) {
                    echo "<tr>";
                    echo    "<td style='border: 1px solid black; width: 5%; text-align: center; padding: 5px;'>".$no."</td>";
                    echo    "<td style='border: 1px solid black; width: 45%; padding: 5px;'>".$data->Part_Number."<br>".$data->Part_Name."</td>";
                    echo    "<td style='border: 1px solid black; width: 10%; text-align: center; padding: 5px;'>".$data->Unit."</td>";
                    echo    "<td style='border: 1px solid black; width: 8%; text-align: right; padding: 5px;'>".$data->Qty."</td>";
                    echo    "<td style='border: 1px solid black; width: 32%; padding: 5px;'>".$data->Remark."</td>";
                    echo "</tr>";
                    $no++;
                }
            }
        ?>
    </table>
</div>

<br>

<table style="border-collapse: collapse; font-size: 80%; table-layout: fixed;">
    <tr>    
        <td style="border-right: 1px solid black; width: 60%; text-align: center; padding: 5px;"></td>
        <td style="border: 1px solid black; width: 20%; text-align: center; padding: 5px;"><b>DISERAHKAN</b></td>
        <td style="border: 1px solid black; width: 20%; text-align: center; padding: 5px;"><b>DITERIMA</b></td>
    </tr>
    <tr>    
        <td style="border-right: 1px solid black; width: 60%; text-align: center; padding: 5px;" height="60" valign="bottom"></td>
        <td style="line-height: 14px; border: 1px solid black; width: 20%; text-align: center; padding: 5px;" height="60" valign="bottom">Purchasing Dept.</td>
        <td style="border: 1px solid black; width: 20%; text-align: center; padding: 5px;" height="60" valign="bottom"></td>
    </tr>
    <tr>    
        <td style="border-right: 1px solid black; width: 60%; padding: 5px;">1. Asli : Pur 2. Merah : Dept. Requester</td>
        <td style="line-height: 14px; border: 1px solid black; width: 20%; padding: 5px;">NAMA : <b><?php echo $pengirim; ?></b></td>
        <td style="border: 1px solid black; width: 20%; padding: 5px;">NAMA : <b><?php echo $penerima; ?></b></td>
    </tr>
</table>