<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Helper hotel
if ( ! function_exists('post'))
{ 
function post($name=''){
	$CI =& get_instance();
	return $CI->input->post($name);
}
}

if ( ! function_exists('get'))
{
function get($name=''){
	$CI =& get_instance();
	return $CI->input->get($name);
}
}

if ( ! function_exists('urisegment'))
{
function urisegment($name=''){
	$CI =& get_instance();
	return $CI->uri->segment($name);;
}
}

if ( ! function_exists('now'))
{
function now(){
	$time =new DateTime();
	$time = $time->getTimestamp();
	return $time;
}
}

if ( ! function_exists('session'))
{
function session($name=''){
	$CI =& get_instance();
	return $CI->session->userdata($name);
}
}

if ( ! function_exists('pr'))
{
function pr($data='', $die=FALSE){
	$CI =& get_instance();
	if($die){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}else{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
}
}

if ( ! function_exists('css_url'))
{
function date_mysql($tanggal, $format ="Y-m-d"){
	$tanggal = strtotime($tanggal);
	$tanggal = date($format, $tanggal);
	return $tanggal;
}
}