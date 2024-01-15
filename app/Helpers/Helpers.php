<?php

function bulan($bln)
{
    $bulan = $bln;
    Switch ($bulan){

        case 1: 
            $bulan="Januari";
        break;

        case 2: 
            $bulan="Februari";
        break;

        case 3: 
            $bulan="Maret";
        break;

        case 4: 
            $bulan="April";
        break;

        case 5: 
            $bulan="Mei";
        break;

        case 6: 
            $bulan="Juni";
        break;

        case 7: 
            $bulan="Juli";
        break;

        case 8: 
            $bulan="Agustus";
        break;

        case 9: 
            $bulan="September";
        break;

        case 10: 
            $bulan="Oktober";
        break;

        case 11: 
            $bulan="November";
        break;

        case 12: 
            $bulan="Desember";
        break;
    }
    return $bulan;
}

function bulan_angka($bulan)
{
    switch ($bulan):
        
        case "Januari" : $bulan='1';
        break;
        case "Februari" : $bulan='2';
        break;
        case "Maret" : $bulan='3';
        break;
        case "April" : $bulan='4';
        break;
        case "Mei" : $bulan='5';
        break;
        case "Juni" : $bulan='6';
        break;
        case "Juli" : $bulan= '7';
        break;
        case "Agustus" : $bulan = '8';
        break;
        
        case "September" : $bulan= '9';
        break;
        
        case "Oktoober" : $bulan='10';
        break;
        
        case "November" : $bulan='11';
        break;
        
        case "Desember" : $bulan='12';
        break;
        
    endswitch;

    return $bulan;
}

function kategoriKolektibilitas($kolektibilitas)
{
    switch($kolektibilitas):
        case 1 :
            echo "Lancar";
        break;
        case 2 :
            echo "Dalam Perhatian Khusus";
        break;

        case 3 :
            echo "Kurang Lancar";
        break;

        case 4 :
            echo "Diragukan";
        break;

        case 5 :
            echo "Macet";
        break;
    endswitch;
}

function tanggalAkhirBulan($tanggal)
{
    switch($tanggal):
        case '1':
            $tanggal = '31';
        break;

        case '2':
            $tanggal = '28';
        break;

        case '3':
            $tanggal = '31';
        break;

        case '4':
            $tanggal = '30';
        break;

        case '5':
            $tanggal = '31';
        break;

        case '6':
            $tanggal = '30';
        break;

        case '7':
            $tanggal = '31';
        break;

        case '8':
            $tanggal = '31';
        break;

        case '9':
            $tanggal = '30';
        break;

        case '10':
            $tanggal = '31';
        break;

        case '11':
            $tanggal = '30';
        break;

        case '12':
            $tanggal = '31';
        break;

    endswitch;

    return $tanggal;
}

function lower_spacing($word)
{
    return strtolower(preg_replace('/\s+/', '_', $word));
}

function button_general($url, $param, $label)
{
    return '<li><a class="nav-link" style="font-size: 11px;" href="'.url($url, $param).'">'.$label.'</a></li>';
}

function lihat_foto($file)
{
    return '<div style="height:20px"></div>
    <a href="#" onclick="test (this)">
        <img src="'.asset($file).'" class="wd-300p wd-sm-400 mb-3 mb-sm-0 mr-3">
    </a>';
}

function status_proses($data)
{
    $status = 'No';
  
    if($data['divisi'] == 'Business Division' || $data['divisi'] == 'Credit Risk Reviewer'):
        if($data['level_user'] == $data['level_data']):
            $status = 'Yes';
        endif;
    endif;

    if($data['divisi'] == 'Legal'):
        // legal section head
        if($data['return_opini_legal'] == null && $data['level_user'] == 4 && $data['status_legal_opini'] == 'Yes' && $data['legal_section_head'] == null): 
            $status = 'Yes';
        endif; // legal section head kalo baru pertama x proses

        if($data['return_opini_legal'] == null && $data['return_legal_opini'] == 'Yes'): 
            if($data['legal_division_head'] == null && $data['legal_section_head'] == 'Sudah Proses'): 
                $status = 'Yes';
            endif;
        endif; // legal division head kalo baru pertama x proses

        if($data['return_opini_legal'] == 'Revisi Opini' && $data['return_legal_opini'] == 'Yes' ): 
            $status = 'Yes';
        endif; // legal division head kalo return opininya uda di proses section head
    endif;

    if($data['divisi'] == 'Compliance'):

        // complianc section head
        if($data['return_opini_compliance'] == null && $data['level_user'] == 4): 
            if($data['status_compliance_opini'] == 'Yes' && $data['compliance_section_head'] == null):  
                $status = 'Yes';
            endif;
        endif; // kalo baru pertama x proses

        // compliance dept head
        if($data['return_opini_compliance'] == null && $data['return_compliance_opini'] == 'Yes'): 
            if($data['compliance_section_head'] == 'Sudah Proses' && $data['compliance_departemen_head'] == null): 
                $status = 'Yes';
            endif;
        endif; // kalo baru pertama x proses
        
        if($data['return_opini_compliance'] == 'Revisi Opini' && $data['return_compliance_opini'] == 'Yes' ): 
            $status = 'Yes';
        endif; // kalo return opininya uda di proses section head
        
        // aml cft section head
        if($data['return_status_kertas_kerja_screening'] == null && $data['level_user'] == 4):
            if($data['status_worksheet_screening'] == 'Yes' && $data['aml_cft_section_head'] == null):  
                $status = 'Yes';
            endif;
        endif; // kalo baru pertama x proses

        // aml cft dept head
        if($data['return_status_kertas_kerja_screening'] == null && $data['return_worksheet_screening'] == 'Yes'): 
            if($data['aml_cft_section_head'] == 'Sudah Proses'): 
                $status = 'Yes';      
            endif;
        endif; // kalo baru pertama x proses

        if($data['return_status_kertas_kerja_screening'] == 'Revisi' && $data['return_worksheet_screening'] == 'Yes'): 
            $status = 'Yes';      
        endif; // kalor eturn opini uda di proses

        // compliance div head
        if($data['divisi'] == 'Compliance' && $data['status_division_head'] == 'Yes' && $data['compliance_division_head'] == null): 
            if($data['aml_cft_dept_head'] == 'Sudah Proses' && $data['compliance_departemen_head'] == 'Sudah Proses'):
                $status = 'Yes';      
            endif;
        endif; // kalor eturn opini uda di proses
    endif;

    if($data['divisi'] == 'Credit Administration'):
        // cac section head
        if($data['return_opini_cad'] == null && $data['level_user'] == 4): 
            if($data['status_opini_cad'] == 'Yes' && $data['cad_section_head'] == null): 
                $status = 'Yes';
            endif;
        endif; // legal section head kalo baru pertama x proses

        if($data['return_opini_cad'] == null && $data['return_cad_opini'] == 'Yes'): 
            if($data['cad_division_head'] == null && $data['cad_section_head'] == 'Sudah Proses'): 
                $status = 'Yes';
            endif;
        endif; // legal division head kalo baru pertama x proses

        if($data['return_opini_cad'] == 'Revisi Opini' && $data['return_cad_opini'] == 'Yes' ): 
            $status = 'Yes';
        endif; // legal division head kalo return opininya uda di proses section head
    endif;

    return $status;
}

function route_general($url, $caption, $warna)
{
    return '<a href="'.$url.'" class="btn btn-'.$warna.' btn-xs">'.$caption.'</a>';
}

function tombol_general($route, $id, $caption)
{
    return '<a href="'.url($route, $id).'" class="btn btn-secondary">'.$caption.'</a>';
}

function tanggal_expirasi($tanggal, $bulan)
{
    $kld = date('Y-m-d', strtotime("+$bulan months", strtotime($tanggal)));

    return $kld;
}

function diffMonth($start, $end) 
{
 
    return (int)round((strtotime($end)-strtotime($start))/2629800);
}

function button_delete($url)
{
    $url = "'".$url."'";

    return '<a href="javascript:void(0);" onClick="hapus('.$url.')" class="hapus btn btn-danger btn-xs">Hapus</a>';
}

function action_general($url, $caption)
{
    return '<a href="'.$url.'" class="btn btn-primary btn-xs">'.$caption.'</a>';
}