<?php

use Carbon\Carbon;

function ___( $text ) { return $text; }

function get_user_id() {

	return Auth::user()->id ?? 0;

}

function get_project_id() {

	return 1;

}

function ddd( $data ) {

	@header( "Content-type: text/plain" );

	print_r( $data );

	die;

}

function sort_by_label($a, $b)
{
    $a = $a['label'];
    $b = $b['label'];

    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

function get_index_link() {

	$path = request()->path();

	return '/indx?return=' . base64_encode( $path );

}

function get_reminders_link() {

	$path = request()->path();

	return '/rmndrs?return=' . base64_encode( $path );

}

function format_date( $date, $format ) {

	return Carbon::parse( $date )->format( $format );

}
