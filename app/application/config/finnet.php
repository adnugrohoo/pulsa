<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['finnet_aktif']=TRUE;
$config['finnet_user'] = 'PTR857';
$config['finnet_pass'] = 'PTR2018';//'ZORA2016';//


$config['finnet_return']='https://dev.pointers.id/adminb2c/manage/returnfinnet';//url pointer untuk memproses hasil pembayaran dan status kedaluwarsa dari Finnet
$config['finnet_return_suffix']='pointer-finnet';//key untuk url return 

$config['finnet_url'] = 'https://sandbox.finpay.co.id/servicescode/';
$config['finnet_check_status'] = $config['finnet_url'].'check-status-ex.php';
